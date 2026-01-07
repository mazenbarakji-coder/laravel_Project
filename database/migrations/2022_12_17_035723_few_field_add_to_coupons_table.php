<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FewFieldAddToCouponsTable extends Migration
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
            if (!Schema::hasColumn('coupons', 'added_by')) {
                $table->string('added_by')->after('id')->default('admin');
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('coupons', 'coupon_bearer')) {
                $table->string('coupon_bearer')->after('coupon_type')->default('inhouse');
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('coupons', 'seller_id')) {
                $table->bigInteger('seller_id')->after('coupon_bearer')->nullable()->comment('NULL=in-house, 0=all seller');
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('coupons', 'customer_id')) {
                $table->bigInteger('customer_id')->after('seller_id')->nullable()->comment('0 = all customer');
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
            Schema::dropIfExists('added_by');
            Schema::dropIfExists('coupon_bearer');
            Schema::dropIfExists('seller_id');
            Schema::dropIfExists('customer_id');
        });
        }
    }
}
