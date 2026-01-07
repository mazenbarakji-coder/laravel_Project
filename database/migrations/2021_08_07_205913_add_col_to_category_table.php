<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColToCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Only run if the categories table exists
        if (Schema::hasTable('categories')) {
            Schema::table('categories', function (Blueprint $table) {
                // Check if column doesn't already exist
                if (!Schema::hasColumn('categories', 'home_status')) {
                    $table->boolean('home_status')->default(0);
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
        // Only run if the categories table exists
        if (Schema::hasTable('categories')) {
            Schema::table('categories', function (Blueprint $table) {
                // Check if column exists before dropping
                if (Schema::hasColumn('categories', 'home_status')) {
                    $table->dropColumn(['home_status']);
                }
            });
        }
    }
}
