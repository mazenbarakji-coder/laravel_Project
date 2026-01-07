<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Only run if the products table exists
        if (Schema::hasTable('products')) {
                    Schema::table('products', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('products', 'digital_product_file_types')) {
                $table->longText('digital_product_file_types')->nullable()->after('variation');
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('products', 'digital_product_extensions')) {
                $table->longText('digital_product_extensions')->nullable()->after('digital_product_file_types');
            }
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Only run if the products table exists
        if (Schema::hasTable('products')) {
                    Schema::table('products', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('products', 'digital_product_file_types')) {
                $table->dropColumn('digital_product_file_types');
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('products', 'digital_product_extensions')) {
                $table->dropColumn('digital_product_extensions');
            }
        });
        }
    }
};
