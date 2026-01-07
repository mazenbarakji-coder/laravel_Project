<?php
/**
 * Automated script to fix all migrations by adding safety checks
 * 
 * This script will automatically add Schema::hasTable() and Schema::hasColumn()
 * checks to all migrations that use Schema::table() without safety checks.
 * 
 * Usage: php fix-all-migrations.php
 * 
 * WARNING: This will modify your migration files. Make sure you have a backup!
 */

$migrationsPath = __DIR__ . '/database/migrations';
$migrations = glob($migrationsPath . '/*.php');

$fixedCount = 0;
$skippedCount = 0;

foreach ($migrations as $migrationFile) {
    $content = file_get_contents($migrationFile);
    $filename = basename($migrationFile);
    
    // Skip if already has safety checks
    if (preg_match('/Schema::hasTable\(/', $content)) {
        $skippedCount++;
        continue;
    }
    
    // Only process migrations that use Schema::table()
    if (!preg_match('/Schema::table\(/', $content)) {
        $skippedCount++;
        continue;
    }
    
    // Extract table name from Schema::table('table_name', ...)
    if (!preg_match("/Schema::table\(['\"]([^'\"]+)['\"]/", $content, $matches)) {
        $skippedCount++;
        continue;
    }
    
    $tableName = $matches[1];
    
    // Extract column names from the migration
    $columns = [];
    if (preg_match_all("/->(string|integer|bigInteger|boolean|text|decimal|float|date|timestamp|json|enum|unsignedBigInteger|unsignedInteger|tinyInteger|char|longText|mediumText|smallInteger)\(['\"]?([^'\"]+)['\"]?\)/", $content, $columnMatches, PREG_SET_ORDER)) {
        foreach ($columnMatches as $match) {
            $columns[] = $match[2];
        }
    }
    
    // Fix the up() method
    $upPattern = "/(public\s+function\s+up\(\)\s*\{[^}]*Schema::table\(['\"]" . preg_quote($tableName, '/') . "['\"],\s*function\s*\(Blueprint\s+\$table\)\s*\{)([^}]+)(\}\);)/s";
    
    if (preg_match($upPattern, $content, $upMatches)) {
        $tableCheck = "        // Only run if the {$tableName} table exists\n        if (Schema::hasTable('{$tableName}')) {\n";
        $innerContent = $upMatches[2];
        
        // Wrap column additions with hasColumn checks
        $fixedInner = preg_replace_callback(
            "/\$table->(string|integer|bigInteger|boolean|text|decimal|float|date|timestamp|json|enum|unsignedBigInteger|unsignedInteger|tinyInteger|char|longText|mediumText|smallInteger)\(['\"]?([^'\"]+)['\"]?\)([^;]*);/",
            function($matches) use ($tableName) {
                $columnName = $matches[2];
                $rest = $matches[3];
                $method = $matches[1];
                return "            // Check if column doesn't already exist\n            if (!Schema::hasColumn('{$tableName}', '{$columnName}')) {\n                \$table->{$method}('{$columnName}'){$rest};\n            }";
            },
            $innerContent
        );
        
        // Handle dropColumn
        $fixedInner = preg_replace(
            "/\$table->dropColumn\(([^)]+)\);/",
            "            // Check if column exists before dropping\n            if (Schema::hasColumn('{$tableName}', " . '$1' . ")) {\n                \$table->dropColumn(" . '$1' . ");\n            }",
            $fixedInner
        );
        
        // Handle change() method (column type changes)
        $fixedInner = preg_replace(
            "/\$table->([a-zA-Z_]+)\(['\"]?([^'\"]+)['\"]?\)->change\(\);/",
            "            // Check if column exists before changing\n            if (Schema::hasColumn('{$tableName}', '$2')) {\n                \$table->$1('$2')->change();\n            }",
            $fixedInner
        );
        
        $newUpMethod = $upMatches[1] . "\n" . $tableCheck . $fixedInner . "\n        }\n    }";
        $content = str_replace($upMatches[0], $newUpMethod, $content);
    }
    
    // Fix the down() method
    $downPattern = "/(public\s+function\s+down\(\)\s*\{[^}]*Schema::table\(['\"]" . preg_quote($tableName, '/') . "['\"],\s*function\s*\(Blueprint\s+\$table\)\s*\{)([^}]+)(\}\);)/s";
    
    if (preg_match($downPattern, $content, $downMatches)) {
        $tableCheck = "        // Only run if the {$tableName} table exists\n        if (Schema::hasTable('{$tableName}')) {\n";
        $innerContent = $downMatches[2];
        
        // Wrap dropColumn with hasColumn checks
        $fixedInner = preg_replace(
            "/\$table->dropColumn\(([^)]+)\);/",
            "            // Check if column exists before dropping\n            if (Schema::hasColumn('{$tableName}', " . '$1' . ")) {\n                \$table->dropColumn(" . '$1' . ");\n            }",
            $innerContent
        );
        
        $newDownMethod = $downMatches[1] . "\n" . $tableCheck . $fixedInner . "\n        }\n    }";
        $content = str_replace($downMatches[0], $newDownMethod, $content);
    }
    
    // Write the fixed content back
    file_put_contents($migrationFile, $content);
    $fixedCount++;
    
    echo "✅ Fixed: {$filename}\n";
}

echo "\n📊 Summary:\n";
echo "   Fixed: {$fixedCount} migrations\n";
echo "   Skipped: {$skippedCount} migrations (already safe or no Schema::table)\n";
echo "\n✅ All migrations have been fixed!\n";


