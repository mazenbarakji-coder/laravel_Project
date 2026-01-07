<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFreeDeliveryOverAmountAndStatusToSellerTable extends Migration
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
            if (!Schema::hasColumn('sellers', 'free_delivery_status')) {
                $table->integer('free_delivery_status')->after('minimum_order_amount')->default(0);
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('sellers', 'free_delivery_over_amount')) {
                $table->float('free_delivery_over_amount')->after('free_delivery_status')->default(0);
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
            if (!Schema::hasColumn('sellers', 'free_delivery_status')) {
                $table->dropColumn('free_delivery_status');
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('sellers', 'free_delivery_over_amount')) {
                $table->dropColumn('free_delivery_over_amount');
            }
        });
        }
    }
}
