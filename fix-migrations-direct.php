<?php
/**
 * Direct migration fixer - simpler approach
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
    preg_match("/Schema::table\(['\"]([^'\"]+)['\"]/", $content, $m);
    if (!$m) {
        $skipped++;
        continue;
    }
    $table = $m[1];
    
    // Fix up() - wrap Schema::table with if check
    $pattern = "/(public\s+function\s+up\(\)\s*\{[^}]*?)(Schema::table\(['\"]{$table}['\"],\s*function\s*\(Blueprint\s+\$table\)\s*\{)/s";
    
    if (preg_match($pattern, $content, $matches)) {
        $before = $matches[1];
        $tableCall = $matches[2];
        
        // Find the matching closing brace
        $after = substr($content, strpos($content, $tableCall) + strlen($tableCall));
        $depth = 1;
        $inner = '';
        $i = 0;
        while ($depth > 0 && $i < strlen($after)) {
            if ($after[$i] === '{') $depth++;
            if ($after[$i] === '}') $depth--;
            if ($depth > 0) $inner .= $after[$i];
            $i++;
        }
        
        // Add column checks to inner content
        $fixedInner = $inner;
        
        // Add column existence checks for ->string(), ->integer(), etc. (not ->change())
        $fixedInner = preg_replace_callback(
            "/(\s+)\$table->(\w+)\(['\"]?([^'\"]+)['\"]?\)([^;]*);/",
            function($m) use ($table) {
                $indent = $m[1];
                $method = $m[2];
                $col = $m[3];
                $rest = $m[4];
                
                // Skip if it's a method call, not a column definition
                if (in_array($method, ['foreign', 'index', 'unique', 'primary'])) {
                    return $m[0];
                }
                
                // Check if ->change()
                if (strpos($rest, '->change()') !== false) {
                    return "{$indent}if (Schema::hasColumn('{$table}', '{$col}')) {\n{$indent}    \$table->{$method}('{$col}'){$rest};\n{$indent}}";
                } else {
                    return "{$indent}if (!Schema::hasColumn('{$table}', '{$col}')) {\n{$indent}    \$table->{$method}('{$col}'){$rest};\n{$indent}}";
                }
            },
            $fixedInner
        );
        
        // Fix dropColumn
        $fixedInner = preg_replace(
            "/(\s+)\$table->dropColumn\(([^)]+)\);/",
            "$1if (Schema::hasColumn('{$table}', " . trim('$2', "[]'\"") . ")) {\n$1    \$table->dropColumn($2);\n$1}",
            $fixedInner
        );
        
        // Rebuild
        $new = $before . 
            "\n        if (Schema::hasTable('{$table}')) {\n" .
            "            " . $tableCall . $fixedInner . "\n        };\n        }\n    }";
        
        $old = $matches[0] . $inner . '};';
        $content = str_replace($old, $new, $content);
    }
    
    // Fix down() similarly
    $pattern = "/(public\s+function\s+down\(\)\s*\{[^}]*?)(Schema::table\(['\"]{$table}['\"],\s*function\s*\(Blueprint\s+\$table\)\s*\{)/s";
    
    if (preg_match($pattern, $content, $matches)) {
        $before = $matches[1];
        $tableCall = $matches[2];
        
        $after = substr($content, strpos($content, $tableCall) + strlen($tableCall));
        $depth = 1;
        $inner = '';
        $i = 0;
        while ($depth > 0 && $i < strlen($after)) {
            if ($after[$i] === '{') $depth++;
            if ($after[$i] === '}') $depth--;
            if ($depth > 0) $inner .= $after[$i];
            $i++;
        }
        
        $fixedInner = preg_replace(
            "/(\s+)\$table->dropColumn\(([^)]+)\);/",
            "$1if (Schema::hasColumn('{$table}', " . trim('$2', "[]'\"") . ")) {\n$1    \$table->dropColumn($2);\n$1}",
            $inner
        );
        
        if (trim($fixedInner) == '' || trim($fixedInner) == '//') {
            $fixedInner = "\n                // Reversal handled by safety checks";
        }
        
        $new = $before . 
            "\n        if (Schema::hasTable('{$table}')) {\n" .
            "            " . $tableCall . $fixedInner . "\n        };\n        }\n    }";
        
        $old = $matches[0] . $inner . '};';
        $content = str_replace($old, $new, $content);
    }
    
    if ($content !== $original) {
        file_put_contents($file, $content);
        $fixed++;
        echo "✅ {$filename}\n";
    } else {
        $skipped++;
    }
}

echo "\n✅ Fixed: {$fixed}\n";
echo "⏭️  Skipped: {$skipped}\n";




