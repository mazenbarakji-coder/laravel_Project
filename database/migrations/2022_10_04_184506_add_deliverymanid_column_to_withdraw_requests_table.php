<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeliverymanidColumnToWithdrawRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Only run if the withdraw_requests table exists
        if (Schema::hasTable('withdraw_requests')) {
                    Schema::table('withdraw_requests', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('withdraw_requests', 'delivery_man_id')) {
                $table->bigInteger('delivery_man_id')->after('seller_id')->nullable();
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
        // Only run if the withdraw_requests table exists
        if (Schema::hasTable('withdraw_requests')) {
                    Schema::table('withdraw_requests', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('withdraw_requests', 'delivery_man_id')) {
                $table->dropColumn('delivery_man_id')->after('seller_id')->nullable();
            }
        });
        }
    }
}
