<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColToAdminWallet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Only run if the admin_wallets table exists
        if (Schema::hasTable('admin_wallets')) {
                    Schema::table('admin_wallets', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('admin_wallets', 'commission_earned')) {
                $table->float('commission_earned')->default(0);
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('admin_wallets', 'inhouse_sell')) {
                $table->float('inhouse_sell')->default(0);
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('admin_wallets', 'delivery_charge_earned')) {
                $table->float('delivery_charge_earned')->default(0);
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('admin_wallets', 'pending_amount')) {
                $table->float('pending_amount')->default(0);
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
        // Only run if the admin_wallets table exists
        if (Schema::hasTable('admin_wallets')) {
                    Schema::table('admin_wallets', function (Blueprint $table) {
            //
        });
        }
    }
}
