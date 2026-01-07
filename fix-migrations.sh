#!/bin/bash

# Simple bash script to add safety checks to migrations

cd "$(dirname "$0")"
migrations_dir="database/migrations"

fixed=0
skipped=0

for file in "$migrations_dir"/*.php; do
    filename=$(basename "$file")
    
    # Skip if already has safety checks
    if grep -q "Schema::hasTable" "$file"; then
        ((skipped++))
        continue
    fi
    
    # Skip if no Schema::table
    if ! grep -q "Schema::table" "$file"; then
        ((skipped++))
        continue
    fi
    
    # Extract table name
    table=$(grep -oP "Schema::table\(['\"]([^'\"]+)['\"]" "$file" | head -1 | grep -oP "['\"]([^'\"]+)['\"]" | tr -d "'\"")
    
    if [ -z "$table" ]; then
        ((skipped++))
        continue
    fi
    
    # Create backup
    cp "$file" "$file.bak"
    
    # Use perl for in-place editing (more reliable than sed for multi-line)
    perl -i -pe "
        # Fix up() method
        if (/public\s+function\s+up\(\)/) {
            \$in_up = 1;
            \$in_down = 0;
        }
        if (/public\s+function\s+down\(\)/) {
            \$in_up = 0;
            \$in_down = 1;
        }
        
        # Wrap Schema::table with if check
        if (/\s+Schema::table\(['\"]$table['\"]/ && !\$wrapped) {
            \$_ = \"        // Only run if the $table table exists\\n\" .
                 \"        if (Schema::hasTable('$table')) {\\n\" .
                 \"            \" . \$_;
            \$wrapped = 1;
        }
        
        # Close the if block after Schema::table closes
        if (/\s*\}\);/ && \$wrapped) {
            \$_ = \$_ . \"        }\\n\";
            \$wrapped = 0;
        }
    " "$file"
    
    # Check if file was modified
    if ! diff -q "$file" "$file.bak" > /dev/null; then
        rm "$file.bak"
        ((fixed++))
        if [ $fixed -le 20 ]; then
            echo "✅ $filename"
        fi
    else
        mv "$file.bak" "$file"
        ((skipped++))
    fi
done

echo ""
echo "📊 Fixed: $fixed | Skipped: $skipped"


