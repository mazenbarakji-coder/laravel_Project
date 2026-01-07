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
        // Only run if the shops table exists
        if (Schema::hasTable('shops')) {
                    Schema::table('shops', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('shops', 'slug')) {
                $table->string('slug')->default('en')->after('name');
            }
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Only run if the shops table exists
        if (Schema::hasTable('shops')) {
                    Schema::table('shops', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('shops', 'slug')) {
                $table->dropColumn('slug');
            }
        });
        }
    }
};
