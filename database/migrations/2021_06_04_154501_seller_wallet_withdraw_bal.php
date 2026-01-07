<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SellerWalletWithdrawBal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Only run if the seller_wallets table exists
        if (Schema::hasTable('seller_wallets')) {
            Schema::table('seller_wallets', function (Blueprint $table) {
                // Check if columns exist before changing
                if (Schema::hasColumn('seller_wallets', 'withdrawn')) {
                    $table->string('withdrawn')->change();
                }
                if (Schema::hasColumn('seller_wallets', 'balance')) {
                    $table->string('balance')->change();
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
        // Only run if the seller_wallets table exists
        if (Schema::hasTable('seller_wallets')) {
            Schema::table('seller_wallets', function (Blueprint $table) {
                // Revert column type changes if needed
                if (Schema::hasColumn('seller_wallets', 'withdrawn')) {
                    // Note: Reverting string changes may require specific handling
                    // Adjust based on your original column type
                }
                if (Schema::hasColumn('seller_wallets', 'balance')) {
                    // Note: Reverting string changes may require specific handling
                    // Adjust based on your original column type
                }
            });
        }
    }
}
