<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColToSellerWalletsTax extends Migration
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
            if (!Schema::hasColumn('seller_wallets', 'total_tax_collected')) {
                $table->float('total_tax_collected')->default(0);
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
