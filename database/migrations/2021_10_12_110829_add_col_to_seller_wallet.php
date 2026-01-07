<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColToSellerWallet extends Migration
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
            // Check if column doesn't already exist
            if (!Schema::hasColumn('seller_wallets', 'commission_given')) {
                $table->float('commission_given')->default(0);
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('seller_wallets', 'total_earning')) {
                $table->float('total_earning')->default(0);
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('seller_wallets', 'pending_withdraw')) {
                $table->float('pending_withdraw')->default(0);
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('seller_wallets', 'total_withdraw')) {
                $table->float('total_withdraw')->default(0);
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('seller_wallets', 'delivery_charge_earned')) {
                $table->float('delivery_charge_earned')->default(0);
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('seller_wallets', 'collected_cash')) {
                $table->float('collected_cash')->default(0);
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
