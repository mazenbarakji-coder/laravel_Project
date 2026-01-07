<?php
// Simple migration fixer - processes files line by line

$migrationsPath = __DIR__ . '/database/migrations';
$files = glob($migrationsPath . '/*.php');

$fixed = 0;
$skipped = 0;

foreach ($files as $file) {
    $lines = file($file);
    $content = implode('', $lines);
    
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
    
    $newLines = [];
    $inUp = false;
    $inDown = false;
    $inTable = false;
    $indentLevel = 0;
    
    foreach ($lines as $i => $line) {
        // Detect function start
        if (preg_match('/public\s+function\s+up\(\)/', $line)) {
            $inUp = true;
            $inDown = false;
            $newLines[] = $line;
            continue;
        }
        
        if (preg_match('/public\s+function\s+down\(\)/', $line)) {
            $inUp = false;
            $inDown = true;
            $newLines[] = $line;
            continue;
        }
        
        // Detect Schema::table start
        if (preg_match("/Schema::table\(['\"]{$table}['\"]/", $line) && !$inTable) {
            $inTable = true;
            // Add if check before Schema::table
            $indent = str_repeat(' ', 8);
            $newLines[] = $indent . "// Only run if the {$table} table exists\n";
            $newLines[] = $indent . "if (Schema::hasTable('{$table}')) {\n";
            $newLines[] = str_repeat(' ', 12) . $line;
            continue;
        }
        
        // Detect column operations inside Schema::table
        if ($inTable && preg_match('/\$table->(\w+)\([\'"]?([^\'"]+)[\'"]?\)([^;]*);/', $line, $colMatch)) {
            $method = $colMatch[1];
            $col = $colMatch[2];
            $rest = $colMatch[3];
            
            // Skip foreign keys, indexes
            if (in_array($method, ['foreign', 'index', 'unique', 'primary', 'dropForeign', 'dropIndex'])) {
                $newLines[] = $line;
                continue;
            }
            
            // Check if it's ->change()
            if (strpos($rest, '->change()') !== false) {
                $indent = preg_match('/^(\s+)/', $line, $ind) ? $ind[1] : '            ';
                $newLines[] = $indent . "// Check if column exists before changing\n";
                $newLines[] = $indent . "if (Schema::hasColumn('{$table}', '{$col}')) {\n";
                $newLines[] = str_replace($indent, $indent . '    ', $line);
                $newLines[] = $indent . "}\n";
                continue;
            } else {
                $indent = preg_match('/^(\s+)/', $line, $ind) ? $ind[1] : '            ';
                $newLines[] = $indent . "// Check if column doesn't already exist\n";
                $newLines[] = $indent . "if (!Schema::hasColumn('{$table}', '{$col}')) {\n";
                $newLines[] = str_replace($indent, $indent . '    ', $line);
                $newLines[] = $indent . "}\n";
                continue;
            }
        }
        
        // Detect dropColumn
        if ($inTable && preg_match('/\$table->dropColumn\(/', $line)) {
            $indent = preg_match('/^(\s+)/', $line, $ind) ? $ind[1] : '            ';
            preg_match('/\$table->dropColumn\(([^)]+)\)/', $line, $dropMatch);
            $cols = trim($dropMatch[1], "[]'\"");
            $newLines[] = $indent . "// Check if column exists before dropping\n";
            $newLines[] = $indent . "if (Schema::hasColumn('{$table}', {$cols})) {\n";
            $newLines[] = str_replace($indent, $indent . '    ', $line);
            $newLines[] = $indent . "}\n";
            continue;
        }
        
        // Detect closing of Schema::table
        if ($inTable && preg_match('/^\s*\}\);/', $line)) {
            $newLines[] = $line;
            $newLines[] = "        }\n";
            $inTable = false;
            continue;
        }
        
        $newLines[] = $line;
    }
    
    $newContent = implode('', $newLines);
    if ($newContent !== $content) {
        file_put_contents($file, $newContent);
        $fixed++;
        if ($fixed <= 20) {
            echo "✅ " . basename($file) . "\n";
        }
    } else {
        $skipped++;
    }
}

echo "\n📊 Fixed: {$fixed} | Skipped: {$skipped}\n";


