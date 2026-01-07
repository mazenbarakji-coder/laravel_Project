<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDealTypeToFlashDeals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Only run if the flash_deals table exists
        if (Schema::hasTable('flash_deals')) {
            Schema::table('flash_deals', function (Blueprint $table) {
                // Check if column doesn't already exist
                if (!Schema::hasColumn('flash_deals', 'deal_type')) {
                    $table->string('deal_type')->nullable();
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
        // Only run if the flash_deals table exists
        if (Schema::hasTable('flash_deals')) {
            Schema::table('flash_deals', function (Blueprint $table) {
                // Check if column exists before dropping
                if (Schema::hasColumn('flash_deals', 'deal_type')) {
                    $table->dropColumn(['deal_type']);
                }
            });
        }
    }
}
