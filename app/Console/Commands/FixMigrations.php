<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class FixMigrations extends Command
{
    protected $signature = 'migrations:fix';
    protected $description = 'Fix all migrations by adding safety checks';

    public function handle()
    {
        $migrationsPath = database_path('migrations');
        $migrations = File::glob($migrationsPath . '/*.php');
        
        $fixedCount = 0;
        $skippedCount = 0;
        
        foreach ($migrations as $migrationFile) {
            $filename = basename($migrationFile);
            $content = File::get($migrationFile);
            $originalContent = $content;
            
            // Skip if already has safety checks
            if (strpos($content, 'Schema::hasTable') !== false) {
                $skippedCount++;
                continue;
            }
            
            // Only process migrations that use Schema::table()
            if (strpos($content, 'Schema::table') === false) {
                $skippedCount++;
                continue;
            }
            
            // Extract table name
            if (!preg_match("/Schema::table\(['\"]([^'\"]+)['\"]/", $content, $matches)) {
                $skippedCount++;
                continue;
            }
            
            $tableName = $matches[1];
            
            // Simple approach: wrap Schema::table calls with if (Schema::hasTable(...))
            // Fix up() method
            $upPattern = "/(public\s+function\s+up\(\)\s*\{[^}]*?)(Schema::table\(['\"]" . preg_quote($tableName, '/') . "['\"],\s*function\s*\(Blueprint\s+\$table\)\s*\{)/s";
            
            if (preg_match($upPattern, $content, $upMatches, PREG_OFFSET_CAPTURE)) {
                $before = $upMatches[1][0];
                $tableStart = $upMatches[2][0];
                $startPos = $upMatches[2][1];
                
                // Find the closing brace for the Schema::table function
                $afterStart = substr($content, $startPos + strlen($tableStart));
                $braceCount = 1;
                $pos = 0;
                $inner = '';
                
                while ($braceCount > 0 && $pos < strlen($afterStart)) {
                    $char = $afterStart[$pos];
                    if ($char === '{') $braceCount++;
                    if ($char === '}') $braceCount--;
                    if ($braceCount > 0) $inner .= $char;
                    $pos++;
                }
                
                // Process inner content - add column checks
                $fixedInner = $this->processInnerContent($inner, $tableName);
                
                // Reconstruct
                $newUp = $before . 
                    "\n        // Only run if the {$tableName} table exists\n" .
                    "        if (Schema::hasTable('{$tableName}')) {\n" .
                    "            " . $tableStart . $fixedInner . "\n        };\n        }\n    }";
                
                $oldUp = $upMatches[0][0] . $inner . '};';
                $content = str_replace($oldUp, $newUp, $content);
            }
            
            // Fix down() method
            $downPattern = "/(public\s+function\s+down\(\)\s*\{[^}]*?)(Schema::table\(['\"]" . preg_quote($tableName, '/') . "['\"],\s*function\s*\(Blueprint\s+\$table\)\s*\{)/s";
            
            if (preg_match($downPattern, $content, $downMatches, PREG_OFFSET_CAPTURE)) {
                $before = $downMatches[1][0];
                $tableStart = $downMatches[2][0];
                $startPos = $downMatches[2][1];
                
                $afterStart = substr($content, $startPos + strlen($tableStart));
                $braceCount = 1;
                $pos = 0;
                $inner = '';
                
                while ($braceCount > 0 && $pos < strlen($afterStart)) {
                    $char = $afterStart[$pos];
                    if ($char === '{') $braceCount++;
                    if ($char === '}') $braceCount--;
                    if ($braceCount > 0) $inner .= $char;
                    $pos++;
                }
                
                $fixedInner = $this->processInnerContent($inner, $tableName, true);
                
                if (trim($fixedInner) == '' || trim($fixedInner) == '//') {
                    $fixedInner = "\n                // Migration reversal handled by safety checks";
                }
                
                $newDown = $before . 
                    "\n        // Only run if the {$tableName} table exists\n" .
                    "        if (Schema::hasTable('{$tableName}')) {\n" .
                    "            " . $tableStart . $fixedInner . "\n        };\n        }\n    }";
                
                $oldDown = $downMatches[0][0] . $inner . '};';
                $content = str_replace($oldDown, $newDown, $content);
            }
            
            if ($content !== $originalContent) {
                File::put($migrationFile, $content);
                $fixedCount++;
                $this->info("✅ Fixed: {$filename}");
            } else {
                $skippedCount++;
            }
        }
        
        $this->info("\n📊 Summary:");
        $this->info("   ✅ Fixed: {$fixedCount} migrations");
        $this->info("   ⏭️  Skipped: {$skippedCount} migrations");
        $this->info("\n💡 Run 'php artisan migrate --force' to test.");
    }
    
    private function processInnerContent($inner, $tableName, $isDown = false)
    {
        $fixed = $inner;
        
        // Fix column additions (not ->change())
        $fixed = preg_replace_callback(
            "/(\s+)\$table->(string|integer|bigInteger|boolean|text|decimal|float|date|timestamp|json|enum|unsignedBigInteger|unsignedInteger|tinyInteger|char|longText|mediumText|smallInteger|double|unsignedDecimal)\(['\"]?([^'\"]+)['\"]?\)([^;]*);/",
            function($m) use ($tableName, $isDown) {
                $indent = $m[1];
                $method = $m[2];
                $col = $m[3];
                $rest = $m[4];
                
                // Check if it's a ->change() call
                if (strpos($rest, '->change()') !== false) {
                    return "{$indent}// Check if column exists before changing\n{$indent}if (Schema::hasColumn('{$tableName}', '{$col}')) {\n{$indent}    \$table->{$method}('{$col}'){$rest};\n{$indent}}";
                } else {
                    return "{$indent}// Check if column doesn't already exist\n{$indent}if (!Schema::hasColumn('{$tableName}', '{$col}')) {\n{$indent}    \$table->{$method}('{$col}'){$rest};\n{$indent}}";
                }
            },
            $fixed
        );
        
        // Fix dropColumn
        $fixed = preg_replace(
            "/(\s+)\$table->dropColumn\(([^)]+)\);/",
            "$1// Check if column exists before dropping\n$1if (Schema::hasColumn('{$tableName}', " . trim('$2', "[]'\"") . ")) {\n$1    \$table->dropColumn($2);\n$1}",
            $fixed
        );
        
        // Fix renameColumn
        $fixed = preg_replace(
            "/(\s+)\$table->renameColumn\(['\"]?([^'\"]+)['\"]?,\s*['\"]?([^'\"]+)['\"]?\);/",
            "$1// Check if column exists before renaming\n$1if (Schema::hasColumn('{$tableName}', '$2')) {\n$1    \$table->renameColumn('$2', '$3');\n$1}",
            $fixed
        );
        
        return $fixed;
    }
}


