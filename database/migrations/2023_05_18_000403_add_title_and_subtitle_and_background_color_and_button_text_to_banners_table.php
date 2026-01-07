<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTitleAndSubtitleAndBackgroundColorAndButtonTextToBannersTable extends Migration
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
            if (!Schema::hasColumn('banners', 'title')) {
                $table->string('title')->after('resource_id')->nullable();
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('banners', 'sub_title')) {
                $table->string('sub_title')->after('title')->nullable();
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('banners', 'button_text')) {
                $table->string('button_text')->after('sub_title')->nullable();
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('banners', 'background_color')) {
                $table->string('background_color')->after('button_text')->nullable();
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
            Schema::dropIfExists('title');
            Schema::dropIfExists('sub_title');
            Schema::dropIfExists('button_text');
            Schema::dropIfExists('background_color');
        });
        }
    }
}
