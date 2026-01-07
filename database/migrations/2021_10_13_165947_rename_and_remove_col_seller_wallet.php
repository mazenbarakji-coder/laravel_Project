<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameAndRemoveColSellerWallet extends Migration
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
                // Only rename if balance exists and total_earning doesn't exist yet
                if (Schema::hasColumn('seller_wallets', 'balance') && !Schema::hasColumn('seller_wallets', 'total_earning')) {
                    $table->renameColumn('balance', 'total_earning');
                }
                // If total_earning already exists, the migration was already run, skip it
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
                // Reverse: rename total_earning back to balance
                if (Schema::hasColumn('seller_wallets', 'total_earning') && !Schema::hasColumn('seller_wallets', 'balance')) {
                    $table->renameColumn('total_earning', 'balance');
                }
            });
        }
    }
}
