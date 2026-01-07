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
            // Check if column exists before changing
            if (Schema::hasColumn('products', 'denied_note')) {
                $table->text('denied_note')->nullable()->change();
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
            //
        });
        }
    }
};
