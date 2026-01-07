<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBillingToOrdersTable extends Migration
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
            if (!Schema::hasColumn('orders', 'billing_address')) {
                $table->unsignedBigInteger('billing_address')->nullable();
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('orders', 'billing_address_data')) {
                $table->string('billing_address_data')->nullable();
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
            if (!Schema::hasColumn('orders', 'billing_address')) {
                $table->dropColumn('billing_address');
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('orders', 'billing_address_data')) {
                $table->dropColumn('billing_address_data');
            }
        });
        }
    }
}
