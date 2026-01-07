<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductTypeAndDigitalProductTypeAndDigitalFileReadyToCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Only run if the carts table exists
        if (Schema::hasTable('carts')) {
                    Schema::table('carts', function (Blueprint $table) {
            $table->string('product_type', 20)->after('product_id')->default('physical');
            $table->string('digital_product_type', 30)->after('product_type')->nullable();
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
        // Only run if the carts table exists
        if (Schema::hasTable('carts')) {
                    Schema::table('carts', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('carts', 'product_type')) {
                $table->dropColumn('product_type');
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('carts', 'digital_product_type')) {
                $table->dropColumn('digital_product_type');
            }
        });
        }
    }
}
