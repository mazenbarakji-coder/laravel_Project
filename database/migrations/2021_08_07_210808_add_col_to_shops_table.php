<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColToShopsTable extends Migration
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
                if (!Schema::hasColumn('shops', 'banner')) {
                    $table->string('banner');
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
                // Check if column exists before dropping
                if (Schema::hasColumn('shops', 'banner')) {
                    $table->dropColumn(['banner']);
                }
            });
        }
    }
}
