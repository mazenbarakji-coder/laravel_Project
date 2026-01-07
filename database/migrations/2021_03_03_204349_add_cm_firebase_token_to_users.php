<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCmFirebaseTokenToUsers extends Migration
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
                if (!Schema::hasColumn('users', 'cm_firebase_token')) {
                    $table->string('cm_firebase_token')->nullable();
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
                // Check if column exists before dropping
                if (Schema::hasColumn('users', 'cm_firebase_token')) {
                    $table->dropColumn(['cm_firebase_token']);
                }
            });
        }
    }
}
