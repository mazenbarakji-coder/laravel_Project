<?php
/**
 * Helper script to identify migrations that might fail due to missing tables
 * 
 * Usage: php fix-migrations.php
 * 
 * This script will list all migrations that use Schema::table() without
 * checking if the table exists first.
 */

$migrationsPath = __DIR__ . '/database/migrations';
$migrations = glob($migrationsPath . '/*.php');

$problematicMigrations = [];

foreach ($migrations as $migrationFile) {
    $content = file_get_contents($migrationFile);
    $filename = basename($migrationFile);
    
    // Check if migration uses Schema::table() but doesn't check for table existence
    if (preg_match('/Schema::table\(/', $content)) {
        // Check if it has safety checks
        if (!preg_match('/Schema::hasTable\(/', $content)) {
            // Extract table name
            if (preg_match("/Schema::table\(['\"]([^'\"]+)['\"]/", $content, $matches)) {
                $tableName = $matches[1];
                $problematicMigrations[] = [
                    'file' => $filename,
                    'table' => $tableName,
                    'path' => $migrationFile
                ];
            }
        }
    }
}

if (empty($problematicMigrations)) {
    echo "✅ All migrations appear to have safety checks!\n";
} else {
    echo "⚠️  Found " . count($problematicMigrations) . " migrations that might fail if tables don't exist:\n\n";
    
    foreach ($problematicMigrations as $migration) {
        echo "📄 {$migration['file']}\n";
        echo "   Table: {$migration['table']}\n";
        echo "   Path: {$migration['path']}\n\n";
    }
    
    echo "\n💡 To fix these migrations, add safety checks like:\n";
    echo "   if (Schema::hasTable('table_name')) {\n";
    echo "       Schema::table('table_name', function (Blueprint \$table) {\n";
    echo "           if (!Schema::hasColumn('table_name', 'column_name')) {\n";
    echo "               \$table->string('column_name')->nullable();\n";
    echo "           }\n";
    echo "       });\n";
    echo "   }\n";
}


