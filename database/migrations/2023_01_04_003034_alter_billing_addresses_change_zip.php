<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterBillingAddressesChangeZip extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Only run if the billing_addresses table exists
        if (Schema::hasTable('billing_addresses')) {
                    Schema::table('billing_addresses', function (Blueprint $table) {
            // Check if column exists before changing
            if (Schema::hasColumn('billing_addresses', 'zip')) {
                $table->string('zip')->change();
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
        // Only run if the billing_addresses table exists
        if (Schema::hasTable('billing_addresses')) {
                    Schema::table('billing_addresses', function (Blueprint $table) {
            //
        });
        }
    }
}
