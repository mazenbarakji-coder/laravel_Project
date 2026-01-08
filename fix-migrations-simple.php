<?php
/**
 * Simple and reliable script to fix all migrations
 * Uses direct pattern matching and replacement
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
    $modified = false;
    
    // Fix up() method - find the Schema::table block and wrap it
    $upPattern = "/(public\s+function\s+up\(\)\s*\{[^\{]*?)(Schema::table\(['\"]" . preg_quote($tableName, '/') . "['\"],\s*function\s*\(Blueprint\s+\$table\)\s*\{)/s";
    
    if (preg_match($upPattern, $content, $upMatches)) {
        $before = $upMatches[1];
        $tableStart = $upMatches[2];
        
        // Find the matching closing brace for the function
        $rest = substr($content, strlen($upMatches[0]));
        $braceCount = 1;
        $pos = 0;
        $innerContent = '';
        
        while ($braceCount > 0 && $pos < strlen($rest)) {
            $char = $rest[$pos];
            if ($char === '{') $braceCount++;
            if ($char === '}') $braceCount--;
            if ($braceCount > 0) $innerContent .= $char;
            $pos++;
        }
        
        // Process inner content
        $fixedInner = $innerContent;
        
        // Fix column additions (not ->change())
        $fixedInner = preg_replace_callback(
            "/(\s+)\$table->(string|integer|bigInteger|boolean|text|decimal|float|date|timestamp|json|enum|unsignedBigInteger|unsignedInteger|tinyInteger|char|longText|mediumText|smallInteger|double|unsignedDecimal)\(['\"]?([^'\"]+)['\"]?\)([^;]*);/",
            function($m) use ($tableName) {
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
            $fixedInner
        );
        
        // Fix dropColumn
        $fixedInner = preg_replace(
            "/(\s+)\$table->dropColumn\(([^)]+)\);/",
            "$1// Check if column exists before dropping\n$1if (Schema::hasColumn('{$tableName}', " . trim('$2', "[]'\"") . ")) {\n$1    \$table->dropColumn($2);\n$1}",
            $fixedInner
        );
        
        // Fix renameColumn  
        $fixedInner = preg_replace(
            "/(\s+)\$table->renameColumn\(['\"]?([^'\"]+)['\"]?,\s*['\"]?([^'\"]+)['\"]?\);/",
            "$1// Check if column exists before renaming\n$1if (Schema::hasColumn('{$tableName}', '$2')) {\n$1    \$table->renameColumn('$2', '$3');\n$1}",
            $fixedInner
        );
        
        // Reconstruct
        $newUp = $before . 
            "\n        // Only run if the {$tableName} table exists\n" .
            "        if (Schema::hasTable('{$tableName}')) {\n" .
            "            " . $tableStart . $fixedInner . "\n        };\n        }\n    }";
        
        $content = str_replace($upMatches[0] . $innerContent . '};', $newUp, $content);
        $modified = true;
    }
    
    // Fix down() method similarly
    $downPattern = "/(public\s+function\s+down\(\)\s*\{[^\{]*?)(Schema::table\(['\"]" . preg_quote($tableName, '/') . "['\"],\s*function\s*\(Blueprint\s+\$table\)\s*\{)/s";
    
    if (preg_match($downPattern, $content, $downMatches)) {
        $before = $downMatches[1];
        $tableStart = $downMatches[2];
        
        $rest = substr($content, strlen($downMatches[0]));
        $braceCount = 1;
        $pos = 0;
        $innerContent = '';
        
        while ($braceCount > 0 && $pos < strlen($rest)) {
            $char = $rest[$pos];
            if ($char === '{') $braceCount++;
            if ($char === '}') $braceCount--;
            if ($braceCount > 0) $innerContent .= $char;
            $pos++;
        }
        
        $fixedInner = $innerContent;
        
        // Fix dropColumn in down()
        $fixedInner = preg_replace(
            "/(\s+)\$table->dropColumn\(([^)]+)\);/",
            "$1// Check if column exists before dropping\n$1if (Schema::hasColumn('{$tableName}', " . trim('$2', "[]'\"") . ")) {\n$1    \$table->dropColumn($2);\n$1}",
            $fixedInner
        );
        
        if (trim($fixedInner) == '' || trim($fixedInner) == '//') {
            $fixedInner = "\n                // Migration reversal handled by safety checks";
        }
        
        $newDown = $before . 
            "\n        // Only run if the {$tableName} table exists\n" .
            "        if (Schema::hasTable('{$tableName}')) {\n" .
            "            " . $tableStart . $fixedInner . "\n        };\n        }\n    }";
        
        $content = str_replace($downMatches[0] . $innerContent . '};', $newDown, $content);
        $modified = true;
    }
    
    if ($modified && $content !== $originalContent) {
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




