<?php
/**
 * Final comprehensive migration fixer
 * Uses a simple template-based approach
 */

$migrationsPath = __DIR__ . '/database/migrations';
$files = glob($migrationsPath . '/*.php');

$fixed = 0;
$skipped = 0;

foreach ($files as $file) {
    $content = file_get_contents($file);
    $original = $content;
    $filename = basename($file);
    
    // Skip if already fixed
    if (strpos($content, 'Schema::hasTable') !== false) {
        $skipped++;
        continue;
    }
    
    // Skip if no Schema::table
    if (strpos($content, 'Schema::table') === false) {
        $skipped++;
        continue;
    }
    
    // Get table name
    if (!preg_match("/Schema::table\(['\"]([^'\"]+)['\"]/", $content, $m)) {
        $skipped++;
        continue;
    }
    $table = $m[1];
    
    // Simple replacement: wrap Schema::table with if check
    // Fix up() method
    $upReplacement = "        // Only run if the {$table} table exists\n        if (Schema::hasTable('{$table}')) {\n            Schema::table('{$table}', function (Blueprint \$table) {";
    
    $content = preg_replace(
        "/(public\s+function\s+up\(\)\s*\{[^}]*?)Schema::table\(['\"]{$table}['\"],\s*function\s*\(Blueprint\s+\$table\)\s*\{/",
        '$1' . $upReplacement,
        $content
    );
    
    // Find and close the if block for up()
    if (strpos($content, $upReplacement) !== false) {
        // Find the closing }; of Schema::table and add closing for if
        $content = preg_replace(
            "/(Schema::table\(['\"]{$table}['\"],\s*function\s*\(Blueprint\s+\$table\)\s*\{[^}]*?\})\);/s",
            '$1' . "\n        };\n        }",
            $content,
            1
        );
        
        // Add column checks inside
        $content = preg_replace_callback(
            "/(Schema::table\(['\"]{$table}['\"],\s*function\s*\(Blueprint\s+\$table\)\s*\{)(.*?)(\}\);)/s",
            function($matches) use ($table) {
                $start = $matches[1];
                $inner = $matches[2];
                $end = $matches[3];
                
                // Add column checks
                $fixed = preg_replace_callback(
                    "/(\s+)\$table->(\w+)\(['\"]?([^'\"]+)['\"]?\)([^;]*);/",
                    function($m) use ($table) {
                        $indent = $m[1];
                        $method = $m[2];
                        $col = $m[3];
                        $rest = $m[4];
                        
                        // Skip foreign, index, etc.
                        if (in_array($method, ['foreign', 'index', 'unique', 'primary', 'dropForeign', 'dropIndex'])) {
                            return $m[0];
                        }
                        
                        if (strpos($rest, '->change()') !== false) {
                            return "{$indent}if (Schema::hasColumn('{$table}', '{$col}')) {\n{$indent}    \$table->{$method}('{$col}'){$rest};\n{$indent}}";
                        } else {
                            return "{$indent}if (!Schema::hasColumn('{$table}', '{$col}')) {\n{$indent}    \$table->{$method}('{$col}'){$rest};\n{$indent}}";
                        }
                    },
                    $inner
                );
                
                // Fix dropColumn
                $fixed = preg_replace(
                    "/(\s+)\$table->dropColumn\(([^)]+)\);/",
                    "$1if (Schema::hasColumn('{$table}', " . trim('$2', "[]'\"") . ")) {\n$1    \$table->dropColumn($2);\n$1}",
                    $fixed
                );
                
                return $start . $fixed . $end;
            },
            $content,
            1
        );
    }
    
    // Fix down() method similarly
    $downReplacement = "        // Only run if the {$table} table exists\n        if (Schema::hasTable('{$table}')) {\n            Schema::table('{$table}', function (Blueprint \$table) {";
    
    $content = preg_replace(
        "/(public\s+function\s+down\(\)\s*\{[^}]*?)Schema::table\(['\"]{$table}['\"],\s*function\s*\(Blueprint\s+\$table\)\s*\{/",
        '$1' . $downReplacement,
        $content
    );
    
    if (strpos($content, $downReplacement) !== false) {
        $content = preg_replace(
            "/(Schema::table\(['\"]{$table}['\"],\s*function\s*\(Blueprint\s+\$table\)\s*\{[^}]*?\})\);/s",
            '$1' . "\n        };\n        }",
            $content,
            1
        );
    }
    
    if ($content !== $original) {
        file_put_contents($file, $content);
        $fixed++;
        if ($fixed <= 20) {
            echo "✅ {$filename}\n";
        }
    } else {
        $skipped++;
    }
}

echo "\n📊 Fixed: {$fixed} | Skipped: {$skipped}\n";


