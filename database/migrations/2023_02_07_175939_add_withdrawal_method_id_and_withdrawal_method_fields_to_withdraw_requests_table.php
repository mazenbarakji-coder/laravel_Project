<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWithdrawalMethodIdAndWithdrawalMethodFieldsToWithdrawRequestsTable extends Migration
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
            if (!Schema::hasColumn('withdraw_requests', 'withdrawal_method_id')) {
                $table->foreignId('withdrawal_method_id')->after('amount')->nullable();
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('withdraw_requests', 'withdrawal_method_fields')) {
                $table->json('withdrawal_method_fields')->after('withdrawal_method_id')->nullable();
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
            Schema::dropIfExists('withdrawal_method_fields');
            Schema::dropIfExists('withdrawal_method_id');
        });
        }
    }
}
