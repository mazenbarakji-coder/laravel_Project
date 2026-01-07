<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategorySubCategoryAndSubSubCategoryAddInProductTable extends Migration
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
            // Check if column doesn't already exist
            if (!Schema::hasColumn('products', 'category_id')) {
                $table->string('category_id')->after('category_ids')->nullable();
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('products', 'sub_category_id')) {
                $table->string('sub_category_id')->after('category_id')->nullable();
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('products', 'sub_sub_category_id')) {
                $table->string('sub_sub_category_id')->after('sub_category_id')->nullable();
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
            Schema::dropIfExists('category_id');
            Schema::dropIfExists('sub_category_id');
            Schema::dropIfExists('sub_sub_category_id');
        });
        }
    }
}
