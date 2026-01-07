<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductTypeAndDigitalProductTypeAndDigitalFileToOrderDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Only run if the order_details table exists
        if (Schema::hasTable('order_details')) {
                    Schema::table('order_details', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('order_details', 'digital_file_after_sell')) {
                $table->string('digital_file_after_sell')->after('seller_id')->nullable();
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
        // Only run if the order_details table exists
        if (Schema::hasTable('order_details')) {
                    Schema::table('order_details', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('order_details', 'digital_file_after_sell')) {
                $table->dropColumn('digital_file_after_sell');
            }
        });
        }
    }
}
