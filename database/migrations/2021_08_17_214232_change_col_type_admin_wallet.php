<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColTypeAdminWallet extends Migration
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
            // Check if column exists before changing
            if (Schema::hasColumn('admin_wallets', 'balance')) {
                $table->float('balance')->change();
            }
            // Check if column exists before changing
            if (Schema::hasColumn('admin_wallets', 'withdrawn')) {
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
        // Only run if the admin_wallets table exists
        if (Schema::hasTable('admin_wallets')) {
                    Schema::table('admin_wallets', function (Blueprint $table) {
            //
        });
        }
    }
}
