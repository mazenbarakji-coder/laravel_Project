<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOfferBannerToShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Only run if the shops table exists
        if (Schema::hasTable('shops')) {
                    Schema::table('shops', function (Blueprint $table) {
            //
            // Check if column doesn't already exist
            if (!Schema::hasColumn('shops', 'offer_banner')) {
                $table->string('offer_banner')->after('bottom_banner')->nullable();
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
        // Only run if the shops table exists
        if (Schema::hasTable('shops')) {
                    Schema::table('shops', function (Blueprint $table) {
            //
            // Check if column doesn't already exist
            if (!Schema::hasColumn('shops', 'offer_banner')) {
                $table->dropColumn('offer_banner');
            }
        });
        }
    }
}
