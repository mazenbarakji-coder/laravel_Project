<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSocialColumnToUsersTable extends Migration
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
            if (!Schema::hasColumn('users', 'login_medium')) {
                $table->string('login_medium')->nullable();
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('users', 'social_id')) {
                $table->string('social_id')->nullable();
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
            //
        });
        }
    }
}
