<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmailColumnToshippingAddressTable extends Migration
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
            if (!Schema::hasColumn('shipping_addresses', 'email')) {
                $table->string('email')->nullable()->after('contact_person_name');
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
            if (!Schema::hasColumn('shipping_addresses', 'email')) {
                $table->dropColumn('email');
            }
        });
        }
    }
}
