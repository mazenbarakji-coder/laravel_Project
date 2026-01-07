<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMultipleColumnToRefundRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Only run if the refund_requests table exists
        if (Schema::hasTable('refund_requests')) {
                    Schema::table('refund_requests', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('refund_requests', 'approved_note')) {
                $table->longText('approved_note')->nullable();
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('refund_requests', 'rejected_note')) {
                $table->longText('rejected_note')->nullable();
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('refund_requests', 'payment_info')) {
                $table->longText('payment_info')->nullable();
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('refund_requests', 'change_by')) {
                $table->string('change_by')->nullable();
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
        // Only run if the refund_requests table exists
        if (Schema::hasTable('refund_requests')) {
                    Schema::table('refund_requests', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('refund_requests', 'approved_note')) {
                $table->dropColumn('approved_note');
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('refund_requests', 'rejected_note')) {
                $table->dropColumn('rejected_note');
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('refund_requests', 'payment_info')) {
                $table->dropColumn('payment_info');
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('refund_requests', 'change_by')) {
                $table->dropColumn('change_by');
            }
        });
        }
    }
}
