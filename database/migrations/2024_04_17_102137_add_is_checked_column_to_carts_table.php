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
        // Only run if the carts table exists
        if (Schema::hasTable('carts')) {
                    Schema::table('carts', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('carts', 'is_checked')) {
                $table->boolean('is_checked')->default(0)->after('tax_model');
            }
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Only run if the carts table exists
        if (Schema::hasTable('carts')) {
                    Schema::table('carts', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('carts', 'is_checked')) {
                $table->dropColumn('is_checked');
            }
        });
        }
    }
};
