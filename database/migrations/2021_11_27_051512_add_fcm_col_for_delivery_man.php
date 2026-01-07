<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFcmColForDeliveryMan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Only run if the delivery_men table exists
        if (Schema::hasTable('delivery_men')) {
                    Schema::table('delivery_men', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('delivery_men', 'fcm_token')) {
                $table->string('fcm_token')->nullable();
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
        // Only run if the delivery_men table exists
        if (Schema::hasTable('delivery_men')) {
                    Schema::table('delivery_men', function (Blueprint $table) {
            //
        });
        }
    }
}
