<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameAndRemoveColAdminWallet extends Migration
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
            if (!Schema::hasColumn('admin_wallets', 'inhouse_sell')) {
                $table->dropColumn('inhouse_sell');
            }
            $table->renameColumn('balance', 'inhouse_earning');
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
