<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBottomBannerToShopsTable extends Migration
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
            // Check if column doesn't already exist
            if (!Schema::hasColumn('shops', 'bottom_banner')) {
                $table->string('bottom_banner')->after('image')->nullable();
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
            Schema::dropIfExists('bottom_banner');
        });
        }
    }
}
