<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLatLongToShippingAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Only run if the shipping_addresses table exists
        if (Schema::hasTable('shipping_addresses')) {
                    Schema::table('shipping_addresses', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('shipping_addresses', 'latitude')) {
                $table->string('latitude')->nullable();
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('shipping_addresses', 'longitude')) {
                $table->string('longitude')->nullable();
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
        // Only run if the shipping_addresses table exists
        if (Schema::hasTable('shipping_addresses')) {
                    Schema::table('shipping_addresses', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('shipping_addresses', 'latitude')) {
                $table->dropColumn('latitude');
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('shipping_addresses', 'longitude')) {
                $table->dropColumn('longitude');
            }
        });
        }
    }
}
