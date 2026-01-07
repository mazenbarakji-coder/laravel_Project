<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCouponDiscountBearerAndAdminCommissionToOrders extends Migration
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
            // Check if column doesn't already exist
            if (!Schema::hasColumn('orders', 'coupon_discount_bearer')) {
                $table->string('coupon_discount_bearer')->after('coupon_code')->default('inhouse');
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('orders', 'admin_commission')) {
                $table->decimal('admin_commission')->after('order_amount')->default(0);
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
            Schema::dropIfExists('coupon_discount_bearer');
            Schema::dropIfExists('admin_commission');
        });
        }
    }
}
