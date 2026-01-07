<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeliveryInfoToOrdersTable extends Migration
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
            if (!Schema::hasColumn('orders', 'delivery_type')) {
                $table->string('delivery_type')->nullable();
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('orders', 'delivery_service_name')) {
                $table->string('delivery_service_name')->nullable();
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('orders', 'third_party_delivery_tracking_id')) {
                $table->string('third_party_delivery_tracking_id')->nullable();
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
            if (!Schema::hasColumn('orders', 'delivery_type')) {
                $table->dropColumn('delivery_type');
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('orders', 'delivery_service_name')) {
                $table->dropColumn('delivery_service_name');
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('orders', 'third_party_delivery_tracking_id')) {
                $table->dropColumn('third_party_delivery_tracking_id');
            }
        });
        }
    }
}
