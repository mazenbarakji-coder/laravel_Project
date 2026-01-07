<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeIdToTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Only run if the transactions table exists
        if (Schema::hasTable('transactions')) {
                    Schema::table('transactions', function (Blueprint $table) {
            // Check if column exists before changing
            if (Schema::hasColumn('transactions', 'id')) {
                $table->increments('id')->change();
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
        // Only run if the transactions table exists
        if (Schema::hasTable('transactions')) {
                    Schema::table('transactions', function (Blueprint $table) {
            //
        });
        }
    }
}
