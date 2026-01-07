<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentMethodColumnToWalletTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Only run if the wallet_transactions table exists
        if (Schema::hasTable('wallet_transactions')) {
                    Schema::table('wallet_transactions', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('wallet_transactions', 'payment_method')) {
                $table->string('payment_method')->nullable()->after('transaction_type');
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
        // Only run if the wallet_transactions table exists
        if (Schema::hasTable('wallet_transactions')) {
                    Schema::table('wallet_transactions', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('wallet_transactions', 'payment_method')) {
                $table->dropColumn('payment_method');
            }
        });
        }
    }
}
