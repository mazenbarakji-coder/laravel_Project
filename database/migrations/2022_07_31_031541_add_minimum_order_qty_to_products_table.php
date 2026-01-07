<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMinimumOrderQtyToProductsTable extends Migration
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
            if (!Schema::hasColumn('products', 'minimum_order_qty')) {
                $table->integer('minimum_order_qty')->after('current_stock')->default(1);
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
            // Check if column doesn't already exist
            if (!Schema::hasColumn('products', 'minimum_order_qty')) {
                $table->dropColumn('minimum_order_qty');
            }
        });
        }
    }
}
