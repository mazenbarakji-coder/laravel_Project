<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAppLanguageColumnToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Only run if the users table exists
        if (Schema::hasTable('users')) {
                    Schema::table('users', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('users', 'app_language')) {
                $table->string('app_language')->default('en');
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
        // Only run if the users table exists
        if (Schema::hasTable('users')) {
                    Schema::table('users', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('users', 'app_language')) {
                $table->dropColumn('app_language');
            }
        });
        }
    }
}
