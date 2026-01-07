<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColType extends Migration
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
            // Check if column exists before changing
            if (Schema::hasColumn('order_transactions', 'id')) {
                $table->string('id')->change();
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
        // Only run if the order_transactions table exists
        if (Schema::hasTable('order_transactions')) {
                    Schema::table('order_transactions', function (Blueprint $table) {
            //
        });
        }
    }
}
