<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAddressPhoneCountryCodeColumnToDeliveryMenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Only run if the delivery_men table exists
        if (Schema::hasTable('delivery_men')) {
                    Schema::table('delivery_men', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('delivery_men', 'address')) {
                $table->text('address')->after('l_name')->nullable();
            }
            $table->string('country_code', 20)->after('address')->nullable();
            // Check if column doesn't already exist
            if (!Schema::hasColumn('delivery_men', 'is_online')) {
                $table->tinyInteger('is_online')->default(1)->after('is_active');
            }
            $table->dropUnique(['phone']);
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
        // Only run if the delivery_men table exists
        if (Schema::hasTable('delivery_men')) {
                    Schema::table('delivery_men', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('delivery_men', 'address')) {
                $table->dropColumn('address');
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('delivery_men', 'country_code')) {
                $table->dropColumn('country_code');
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('delivery_men', 'is_online')) {
                $table->dropColumn('is_online');
            }
        });
        }
    }
}
