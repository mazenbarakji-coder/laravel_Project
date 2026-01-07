<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTransactionAmountTable extends Migration
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
            if (!Schema::hasColumn('transactions', 'amount')) {
                $table->float('amount')->default(0);
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('transactions', 'transaction_type')) {
                $table->string('transaction_type')->nullable();
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
            //
        });
        }
    }
}
