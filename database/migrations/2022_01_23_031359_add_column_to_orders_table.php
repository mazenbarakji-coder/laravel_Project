<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToOrdersTable extends Migration
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
            // Check if column doesn't already exist
            if (!Schema::hasColumn('orders', 'order_type')) {
                $table->string('order_type')->default('default_type');
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('orders', 'extra_discount')) {
                $table->float('extra_discount')->default(0);
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('orders', 'extra_discount_type')) {
                $table->string('extra_discount_type')->nullable();
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
            // Check if column doesn't already exist
            if (!Schema::hasColumn('orders', 'order_type')) {
                $table->dropColumn('order_type');
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('orders', 'extra_discount')) {
                $table->dropColumn('extra_discount');
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('orders', 'extra_discount_type')) {
                $table->dropColumn('extra_discount_type');
            }
        });
        }
    }
}
