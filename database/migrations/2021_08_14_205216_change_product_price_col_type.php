<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeProductPriceColType extends Migration
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
                // Check if columns exist before changing
                if (Schema::hasColumn('products', 'unit_price')) {
                    $table->float('unit_price')->change();
                }
                if (Schema::hasColumn('products', 'purchase_price')) {
                    $table->float('purchase_price')->change();
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
                // Revert column type changes if needed
                if (Schema::hasColumn('products', 'unit_price')) {
                    // Note: Reverting float changes may require specific handling
                }
                if (Schema::hasColumn('products', 'purchase_price')) {
                    // Note: Reverting float changes may require specific handling
                }
            });
        }
    }
}
