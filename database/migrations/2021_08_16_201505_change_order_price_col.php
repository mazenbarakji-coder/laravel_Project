<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeOrderPriceCol extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Only run if the orders table exists
        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                // Check if columns exist before changing
                if (Schema::hasColumn('orders', 'order_amount')) {
                    $table->float('order_amount')->change();
                }
                if (Schema::hasColumn('orders', 'discount_amount')) {
                    $table->float('discount_amount')->change();
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
        // Only run if the orders table exists
        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                // Revert column type changes if needed
                if (Schema::hasColumn('orders', 'order_amount')) {
                    // Note: Reverting float changes may require specific handling
                }
                if (Schema::hasColumn('orders', 'discount_amount')) {
                    // Note: Reverting float changes may require specific handling
                }
            });
        }
    }
}
