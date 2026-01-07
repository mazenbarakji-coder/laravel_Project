<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToBanner extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Only run if the banners table exists
        if (Schema::hasTable('banners')) {
                    Schema::table('banners', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('banners', 'resource_type')) {
                $table->string('resource_type')->nullable();
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('banners', 'resource_id')) {
                $table->bigInteger('resource_id')->nullable();
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
        // Only run if the banners table exists
        if (Schema::hasTable('banners')) {
                    Schema::table('banners', function (Blueprint $table) {
            //
        });
        }
    }
}
