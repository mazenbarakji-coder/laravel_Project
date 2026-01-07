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
        // Only run if the brands table exists
        if (Schema::hasTable('brands')) {
                    Schema::table('brands', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('brands', 'image_alt_text')) {
                $table->string('image_alt_text')->nullable()->after('image');
            }
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Only run if the brands table exists
        if (Schema::hasTable('brands')) {
                    Schema::table('brands', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('brands', 'type')) {
                $table->dropColumn('type');
            }
        });
        }
    }
};
