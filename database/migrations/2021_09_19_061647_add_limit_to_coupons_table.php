<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLimitToCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Only run if the coupons table exists
        if (Schema::hasTable('coupons')) {
                    Schema::table('coupons', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('coupons', 'limit')) {
                $table->integer('limit')->nullable();
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
        // Only run if the coupons table exists
        if (Schema::hasTable('coupons')) {
                    Schema::table('coupons', function (Blueprint $table) {
             // Check if column doesn't already exist
             if (!Schema::hasColumn('coupons', 'limit')) {
                 $table->dropColumn('limit');
             }
        });
        }
    }
}
