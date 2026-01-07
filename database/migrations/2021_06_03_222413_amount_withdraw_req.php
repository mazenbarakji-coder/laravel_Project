<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AmountWithdrawReq extends Migration
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
                // Check if column exists before changing
                if (Schema::hasColumn('withdraw_requests', 'amount')) {
                    $table->string('amount')->change();
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
                // Revert column type change if needed
                if (Schema::hasColumn('withdraw_requests', 'amount')) {
                    // Note: Reverting string changes may require specific handling
                    // Adjust based on your original column type
                }
            });
        }
    }
}
