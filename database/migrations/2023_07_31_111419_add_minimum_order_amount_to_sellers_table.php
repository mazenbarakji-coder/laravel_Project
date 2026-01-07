<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMinimumOrderAmountToSellersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Only run if the sellers table exists
        if (Schema::hasTable('sellers')) {
                    Schema::table('sellers', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('sellers', 'minimum_order_amount')) {
                $table->float('minimum_order_amount')->after('pos_status')->default(0);
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
        // Only run if the sellers table exists
        if (Schema::hasTable('sellers')) {
                    Schema::table('sellers', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('sellers', 'minimum_order_amount')) {
                $table->dropColumn('minimum_order_amount');
            }
        });
        }
    }
}
