<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShippingTypeToOrdersTable extends Migration
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
            if (!Schema::hasColumn('orders', 'shipping_type')) {
                $table->string('shipping_type')->nullable();
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
            if (!Schema::hasColumn('orders', 'shipping_type')) {
                $table->dropColumn('shipping_type');
            }
        });
        }
    }
}
