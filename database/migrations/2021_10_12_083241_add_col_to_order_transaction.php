<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColToOrderTransaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Only run if the order_transactions table exists
        if (Schema::hasTable('order_transactions')) {
                    Schema::table('order_transactions', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('order_transactions', 'customer_id')) {
                $table->bigInteger('customer_id')->nullable();
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('order_transactions', 'seller_is')) {
                $table->string('seller_is')->nullable('admin');
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('order_transactions', 'delivered_by')) {
                $table->string('delivered_by')->default('admin');
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('order_transactions', 'payment_method')) {
                $table->string('payment_method')->nullable();
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
        // Only run if the order_transactions table exists
        if (Schema::hasTable('order_transactions')) {
                    Schema::table('order_transactions', function (Blueprint $table) {
            //
        });
        }
    }
}
