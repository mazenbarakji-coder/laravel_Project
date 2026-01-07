<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToOrderDetailsStock extends Migration
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
                if (!Schema::hasColumn('order_details', 'is_stock_decreased')) {
                    $table->boolean('is_stock_decreased')->default(1);
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
                // Check if column exists before dropping
                if (Schema::hasColumn('order_details', 'is_stock_decreased')) {
                    $table->dropColumn(['is_stock_decreased']);
                }
            });
        }
    }
}
