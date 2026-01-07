<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeliverymanChargeAndExpectedDeliveryDate extends Migration
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
            $table->double('deliveryman_charge',50)->default(0)->after('delivery_man_id');
            // Check if column doesn't already exist
            if (!Schema::hasColumn('orders', 'expected_delivery_date')) {
                $table->date('expected_delivery_date')->nullable()->after('deliveryman_charge');
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
            if (!Schema::hasColumn('orders', 'deliveryman_charge')) {
                $table->dropColumn('deliveryman_charge');
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('orders', 'expected_delivery_date')) {
                $table->dropColumn('expected_delivery_date');
            }
        });
        }
    }
}
