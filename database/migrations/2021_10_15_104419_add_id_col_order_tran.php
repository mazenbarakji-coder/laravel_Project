<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdColOrderTran extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Only run if the order_transactions table exists
        if (Schema::hasTable('order_transactions')) {
                    Schema::table('order_transactions', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('order_transactions', 'id')) {
                $table->bigIncrements('id');
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
        Schema::table('order_transaction', function (Blueprint $table) {
            //
        });
    }
}
