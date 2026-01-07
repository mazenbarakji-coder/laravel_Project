<?php
/**
 * Bulk fix all migrations that use Schema::table() without safety checks
 * 
 * This script uses a simpler, more reliable approach to fix migrations.
 */

$migrationsPath = __DIR__ . '/database/migrations';
$migrations = glob($migrationsPath . '/*.php');

$fixedCount = 0;
$skippedCount = 0;

foreach ($migrations as $migrationFile) {
    $filename = basename($migrationFile);
    $content = file_get_contents($migrationFile);
    $originalContent = $content;
    
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
    
    // Extract table name
    if (!preg_match("/Schema::table\(['\"]([^'\"]+)['\"]/", $content, $matches)) {
        $skippedCount++;
        continue;
    }
    
    $tableName = $matches[1];
    
    // Fix up() method - wrap entire Schema::table block
    $upPattern = "/(public\s+function\s+up\(\)\s*\{[^\}]*?)(Schema::table\(['\"]" . preg_quote($tableName, '/') . "['\"],\s*function\s*\(Blueprint\s+\$table\)\s*\{)(.*?)(\}\);)/s";
    
    if (preg_match($upPattern, $content, $upMatches)) {
        $before = $upMatches[1];
        $tableStart = $upMatches[2];
        $inner = $upMatches[3];
        $tableEnd = $upMatches[4];
        
        // Wrap with table check
        $wrapped = $before . 
            "\n        // Only run if the {$tableName} table exists\n" .
            "        if (Schema::hasTable('{$tableName}')) {\n" .
            "            " . $tableStart . "\n";
        
        // Process inner content - add column checks
        $fixedInner = preg_replace_callback(
            "/(\s+)\$table->(string|integer|bigInteger|boolean|text|decimal|float|date|timestamp|json|enum|unsignedBigInteger|unsignedInteger|tinyInteger|char|longText|mediumText|smallInteger|double|unsignedDecimal)\(['\"]?([^'\"]+)['\"]?\)([^;]*);/",
            function($m) use ($tableName) {
                $indent = $m[1];
                $method = $m[2];
                $col = $m[3];
                $rest = $m[4];
                $isChange = strpos($rest, '->change()') !== false;
                
                if ($isChange) {
                    return "{$indent}// Check if column exists before changing\n{$indent}if (Schema::hasColumn('{$tableName}', '{$col}')) {\n{$indent}    \$table->{$method}('{$col}'){$rest};\n{$indent}}";
                } else {
                    return "{$indent}// Check if column doesn't already exist\n{$indent}if (!Schema::hasColumn('{$tableName}', '{$col}')) {\n{$indent}    \$table->{$method}('{$col}'){$rest};\n{$indent}}";
                }
            },
            $inner
        );
        
        // Fix dropColumn
        $fixedInner = preg_replace(
            "/(\s+)\$table->dropColumn\(([^)]+)\);/",
            "$1// Check if column exists before dropping\n$1if (Schema::hasColumn('{$tableName}', " . '$2' . ")) {\n$1    \$table->dropColumn($2);\n$1}",
            $fixedInner
        );
        
        // Fix renameColumn
        $fixedInner = preg_replace(
            "/(\s+)\$table->renameColumn\(['\"]?([^'\"]+)['\"]?,\s*['\"]?([^'\"]+)['\"]?\);/",
            "$1// Check if column exists before renaming\n$1if (Schema::hasColumn('{$tableName}', '$2')) {\n$1    \$table->renameColumn('$2', '$3');\n$1}",
            $fixedInner
        );
        
        $wrapped .= $fixedInner . "\n            " . $tableEnd . "\n        }\n    }";
        $content = str_replace($upMatches[0], $wrapped, $content);
    }
    
    // Fix down() method
    $downPattern = "/(public\s+function\s+down\(\)\s*\{[^\}]*?)(Schema::table\(['\"]" . preg_quote($tableName, '/') . "['\"],\s*function\s*\(Blueprint\s+\$table\)\s*\{)(.*?)(\}\);)/s";
    
    if (preg_match($downPattern, $content, $downMatches)) {
        $before = $downMatches[1];
        $tableStart = $downMatches[2];
        $inner = $downMatches[3];
        $tableEnd = $downMatches[4];
        
        $wrapped = $before . 
            "\n        // Only run if the {$tableName} table exists\n" .
            "        if (Schema::hasTable('{$tableName}')) {\n" .
            "            " . $tableStart . "\n";
        
        // Fix dropColumn in down()
        $fixedInner = preg_replace(
            "/(\s+)\$table->dropColumn\(([^)]+)\);/",
            "$1// Check if column exists before dropping\n$1if (Schema::hasColumn('{$tableName}', " . '$2' . ")) {\n$1    \$table->dropColumn($2);\n$1}",
            $inner
        );
        
        if (trim($fixedInner) == '' || trim($fixedInner) == '//') {
            $fixedInner = "\n                // Migration reversal handled by safety checks";
        }
        
        $wrapped .= $fixedInner . "\n            " . $tableEnd . "\n        }\n    }";
        $content = str_replace($downMatches[0], $wrapped, $content);
    }
    
    if ($content !== $originalContent) {
        file_put_contents($migrationFile, $content);
        $fixedCount++;
        echo "✅ Fixed: {$filename}\n";
    } else {
        $skippedCount++;
    }
}

echo "\n📊 Summary:\n";
echo "   ✅ Fixed: {$fixedCount} migrations\n";
echo "   ⏭️  Skipped: {$skippedCount} migrations\n";
echo "\n💡 Run 'php artisan migrate --force' to test.\n";


