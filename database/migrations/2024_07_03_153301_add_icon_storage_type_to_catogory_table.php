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
        // Only run if the categories table exists
        if (Schema::hasTable('categories')) {
                    Schema::table('categories', function (Blueprint $table) {
            $table->string('icon_storage_type',10)->default('public')->after('icon')->nullable();

        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Only run if the categories table exists
        if (Schema::hasTable('categories')) {
                    Schema::table('categories', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('categories', 'icon_storage_type')) {
                $table->dropColumn('icon_storage_type');
            }
        });
        }
    }
};
