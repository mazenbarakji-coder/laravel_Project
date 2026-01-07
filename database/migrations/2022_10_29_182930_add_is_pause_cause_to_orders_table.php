<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsPauseCauseToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Only run if the orders table exists
        if (Schema::hasTable('orders')) {
                    Schema::table('orders', function (Blueprint $table) {
            $table->string('is_pause', 20)->default(0)->after('order_amount');
            // Check if column doesn't already exist
            if (!Schema::hasColumn('orders', 'cause')) {
                $table->string('cause')->nullable()->after('is_pause');
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
        // Only run if the orders table exists
        if (Schema::hasTable('orders')) {
                    Schema::table('orders', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('orders', 'is_pause')) {
                $table->dropColumn('is_pause');
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('orders', 'cause')) {
                $table->dropColumn('cause');
            }
        });
        }
    }
}
