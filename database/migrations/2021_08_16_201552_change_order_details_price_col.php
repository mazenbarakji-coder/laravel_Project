<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeOrderDetailsPriceCol extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Only run if the order_details table exists
        if (Schema::hasTable('order_details')) {
            Schema::table('order_details', function (Blueprint $table) {
                // Check if columns exist before changing
                if (Schema::hasColumn('order_details', 'price')) {
                    $table->float('price')->change();
                }
                if (Schema::hasColumn('order_details', 'tax')) {
                    $table->float('tax')->change();
                }
                if (Schema::hasColumn('order_details', 'discount')) {
                    $table->float('discount')->change();
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
        // Only run if the order_details table exists
        if (Schema::hasTable('order_details')) {
            Schema::table('order_details', function (Blueprint $table) {
                // Revert column type changes if needed
                if (Schema::hasColumn('order_details', 'price')) {
                    // Note: Reverting float changes may require specific handling
                }
                if (Schema::hasColumn('order_details', 'tax')) {
                    // Note: Reverting float changes may require specific handling
                }
                if (Schema::hasColumn('order_details', 'discount')) {
                    // Note: Reverting float changes may require specific handling
                }
            });
        }
    }
}
