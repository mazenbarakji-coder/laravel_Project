<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRefundIdToRefundTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Only run if the refund_transactions table exists
        if (Schema::hasTable('refund_transactions')) {
                    Schema::table('refund_transactions', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('refund_transactions', 'refund_id')) {
                $table->unsignedBigInteger('refund_id')->nullable();
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
        // Only run if the refund_transactions table exists
        if (Schema::hasTable('refund_transactions')) {
                    Schema::table('refund_transactions', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('refund_transactions', 'refund_id')) {
                $table->dropColumn('refund_id');
            }
        });
        }
    }
}
