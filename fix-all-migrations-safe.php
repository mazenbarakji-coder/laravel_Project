<?php
/**
 * Safe automated script to fix all migrations by adding safety checks
 * 
 * This script will automatically add Schema::hasTable() and Schema::hasColumn()
 * checks to all migrations that use Schema::table() without safety checks.
 * 
 * Usage: php fix-all-migrations-safe.php
 * 
 * WARNING: This will modify your migration files. Make sure you have a backup!
 */

$migrationsPath = __DIR__ . '/database/migrations';
$migrations = glob($migrationsPath . '/*.php');

$fixedCount = 0;
$skippedCount = 0;
$errors = [];

foreach ($migrations as $migrationFile) {
    $filename = basename($migrationFile);
    
    try {
        $content = file_get_contents($migrationFile);
        
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
        $originalContent = $content;
        
        // Fix the up() method
        $upPattern = "/(public\s+function\s+up\(\)\s*\{[^}]*?)(Schema::table\(['\"]" . preg_quote($tableName, '/') . "['\"],\s*function\s*\(Blueprint\s+\$table\)\s*\{)([^}]+?)(\}\);)/s";
        
        if (preg_match($upPattern, $content, $upMatches)) {
            $beforeUp = $upMatches[1];
            $tableStart = $upMatches[2];
            $innerContent = $upMatches[3];
            $tableEnd = $upMatches[4];
            
            // Add table check wrapper
            $tableCheck = "\n        // Only run if the {$tableName} table exists\n        if (Schema::hasTable('{$tableName}')) {\n";
            $tableClose = "\n        }";
            
            // Process column operations in inner content
            $fixedInner = $innerContent;
            
            // Fix column additions (->string(), ->integer(), etc.)
            $fixedInner = preg_replace_callback(
                "/(\s+)\$table->(string|integer|bigInteger|boolean|text|decimal|float|date|timestamp|json|enum|unsignedBigInteger|unsignedInteger|tinyInteger|char|longText|mediumText|smallInteger|double|unsignedDecimal|unsignedDouble|unsignedFloat|unsignedInteger|unsignedMediumInteger|unsignedSmallInteger|unsignedTinyInteger)\(['\"]?([^'\"]+)['\"]?\)([^;]*);/",
                function($matches) use ($tableName, $innerContent) {
                    $indent = $matches[1];
                    $method = $matches[2];
                    $columnName = $matches[3];
                    $rest = $matches[4];
                    
                    // Check if this is a ->change() call
                    if (strpos($rest, '->change()') !== false) {
                        return "{$indent}// Check if column exists before changing\n{$indent}if (Schema::hasColumn('{$tableName}', '{$columnName}')) {\n{$indent}    \$table->{$method}('{$columnName}'){$rest};\n{$indent}}";
                    } else {
                        return "{$indent}// Check if column doesn't already exist\n{$indent}if (!Schema::hasColumn('{$tableName}', '{$columnName}')) {\n{$indent}    \$table->{$method}('{$columnName}'){$rest};\n{$indent}}";
                    }
                },
                $fixedInner
            );
            
            // Fix dropColumn calls
            $fixedInner = preg_replace_callback(
                "/(\s+)\$table->dropColumn\(([^)]+)\);/",
                function($matches) use ($tableName) {
                    $indent = $matches[1];
                    $columns = $matches[2];
                    return "{$indent}// Check if column exists before dropping\n{$indent}if (Schema::hasColumn('{$tableName}', " . trim($columns, "[]'\"") . ")) {\n{$indent}    \$table->dropColumn({$columns});\n{$indent}}";
                },
                $fixedInner
            );
            
            // Fix renameColumn calls
            $fixedInner = preg_replace_callback(
                "/(\s+)\$table->renameColumn\(['\"]?([^'\"]+)['\"]?,\s*['\"]?([^'\"]+)['\"]?\);/",
                function($matches) use ($tableName) {
                    $indent = $matches[1];
                    $oldName = $matches[2];
                    $newName = $matches[3];
                    return "{$indent}// Check if column exists before renaming\n{$indent}if (Schema::hasColumn('{$tableName}', '{$oldName}')) {\n{$indent}    \$table->renameColumn('{$oldName}', '{$newName}');\n{$indent}}";
                },
                $fixedInner
            );
            
            // Reconstruct the up() method
            $newUpMethod = $beforeUp . $tableCheck . $tableStart . $fixedInner . $tableEnd . $tableClose . "\n    }";
            $content = str_replace($upMatches[0], $newUpMethod, $content);
        }
        
        // Fix the down() method
        $downPattern = "/(public\s+function\s+down\(\)\s*\{[^}]*?)(Schema::table\(['\"]" . preg_quote($tableName, '/') . "['\"],\s*function\s*\(Blueprint\s+\$table\)\s*\{)([^}]+?)(\}\);)/s";
        
        if (preg_match($downPattern, $content, $downMatches)) {
            $beforeDown = $downMatches[1];
            $tableStart = $downMatches[2];
            $innerContent = $downMatches[3];
            $tableEnd = $downMatches[4];
            
            // Add table check wrapper
            $tableCheck = "\n        // Only run if the {$tableName} table exists\n        if (Schema::hasTable('{$tableName}')) {\n";
            $tableClose = "\n        }";
            
            // Process column operations in inner content
            $fixedInner = $innerContent;
            
            // Fix dropColumn calls in down()
            $fixedInner = preg_replace_callback(
                "/(\s+)\$table->dropColumn\(([^)]+)\);/",
                function($matches) use ($tableName) {
                    $indent = $matches[1];
                    $columns = $matches[2];
                    return "{$indent}// Check if column exists before dropping\n{$indent}if (Schema::hasColumn('{$tableName}', " . trim($columns, "[]'\"") . ")) {\n{$indent}    \$table->dropColumn({$columns});\n{$indent}}";
                },
                $fixedInner
            );
            
            // If down() is empty, add a comment
            if (trim($fixedInner) == '' || trim($fixedInner) == '//') {
                $fixedInner = "\n            // Migration reversal handled by safety checks";
            }
            
            // Reconstruct the down() method
            $newDownMethod = $beforeDown . $tableCheck . $tableStart . $fixedInner . $tableEnd . $tableClose . "\n    }";
            $content = str_replace($downMatches[0], $newDownMethod, $content);
        }
        
        // Only write if content changed
        if ($content !== $originalContent) {
            file_put_contents($migrationFile, $content);
            $fixedCount++;
            echo "✅ Fixed: {$filename}\n";
        } else {
            $skippedCount++;
        }
        
    } catch (Exception $e) {
        $errors[] = "Error fixing {$filename}: " . $e->getMessage();
        echo "❌ Error: {$filename} - " . $e->getMessage() . "\n";
    }
}

echo "\n📊 Summary:\n";
echo "   Fixed: {$fixedCount} migrations\n";
echo "   Skipped: {$skippedCount} migrations (already safe or no Schema::table)\n";

if (!empty($errors)) {
    echo "   Errors: " . count($errors) . " migrations had errors\n";
    foreach ($errors as $error) {
        echo "   - {$error}\n";
    }
}

echo "\n✅ Migration fixing complete!\n";
echo "💡 Run 'php artisan migrate --force' to test the fixes.\n";




