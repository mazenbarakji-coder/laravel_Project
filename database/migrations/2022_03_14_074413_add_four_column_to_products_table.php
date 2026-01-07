<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFourColumnToProductsTable extends Migration
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
            if (!Schema::hasColumn('products', 'shipping_cost')) {
                $table->float('shipping_cost')->nullable();
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('products', 'multiply_qty')) {
                $table->boolean('multiply_qty')->nullable();
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('products', 'temp_shipping_cost')) {
                $table->float('temp_shipping_cost')->nullable();
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('products', 'is_shipping_cost_updated')) {
                $table->boolean('is_shipping_cost_updated')->nullable();
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
            if (!Schema::hasColumn('products', 'shipping_cost')) {
                $table->dropColumn('shipping_cost');
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('products', 'multiply_qty')) {
                $table->dropColumn('multiply_qty');
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('products', 'temp_shipping_cost')) {
                $table->dropColumn('temp_shipping_cost');
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('products', 'is_shipping_cost_updated')) {
                $table->dropColumn('is_shipping_cost_updated');
            }
        });
        }
    }
}
