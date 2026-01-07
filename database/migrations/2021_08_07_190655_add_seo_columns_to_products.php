<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSeoColumnsToProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Only run if the products table exists
        if (Schema::hasTable('products')) {
            Schema::table('products', function (Blueprint $table) {
                // Check if columns don't already exist
                if (!Schema::hasColumn('products', 'meta_title')) {
                    $table->string('meta_title')->nullable();
                }
                if (!Schema::hasColumn('products', 'meta_description')) {
                    $table->string('meta_description')->nullable();
                }
                if (!Schema::hasColumn('products', 'meta_image')) {
                    $table->string('meta_image')->nullable();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Only run if the products table exists
        if (Schema::hasTable('products')) {
            Schema::table('products', function (Blueprint $table) {
                // Check if columns exist before dropping
                if (Schema::hasColumn('products', 'meta_title')) {
                    $table->dropColumn(['meta_title']);
                }
                if (Schema::hasColumn('products', 'meta_description')) {
                    $table->dropColumn(['meta_description']);
                }
                if (Schema::hasColumn('products', 'meta_image')) {
                    $table->dropColumn(['meta_image']);
                }
            });
        }
    }
}
