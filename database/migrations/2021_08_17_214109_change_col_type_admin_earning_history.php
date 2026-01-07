<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColTypeAdminEarningHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Only run if the admin_wallet_histories table exists
        if (Schema::hasTable('admin_wallet_histories')) {
                    Schema::table('admin_wallet_histories', function (Blueprint $table) {
            // Check if column exists before changing
            if (Schema::hasColumn('admin_wallet_histories', 'amount')) {
                $table->float('amount')->change();
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
        // Only run if the admin_wallet_histories table exists
        if (Schema::hasTable('admin_wallet_histories')) {
                    Schema::table('admin_wallet_histories', function (Blueprint $table) {
            //
        });
        }
    }
}
