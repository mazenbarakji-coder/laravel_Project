<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrderDetailsIdToTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Only run if the transactions table exists
        if (Schema::hasTable('transactions')) {
                    Schema::table('transactions', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('transactions', 'order_details_id')) {
                $table->unsignedBigInteger('order_details_id')->nullable();
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
        // Only run if the transactions table exists
        if (Schema::hasTable('transactions')) {
                    Schema::table('transactions', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('transactions', 'order_details_id')) {
                $table->dropColumn('order_details_id');
            }
        });
        }
    }
}
