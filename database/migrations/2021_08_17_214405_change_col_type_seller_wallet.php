<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColTypeSellerWallet extends Migration
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
            // Check if column exists before changing
            if (Schema::hasColumn('seller_wallets', 'balance')) {
                $table->float('balance')->change();
            }
            // Check if column exists before changing
            if (Schema::hasColumn('seller_wallets', 'withdrawn')) {
                $table->float('withdrawn')->change();
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
            //
        });
        }
    }
}
