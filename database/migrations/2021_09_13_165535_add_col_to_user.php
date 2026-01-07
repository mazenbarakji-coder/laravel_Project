<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColToUser extends Migration
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
            if (!Schema::hasColumn('users', 'is_phone_verified')) {
                $table->boolean('is_phone_verified')->default(0);
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('users', 'temporary_token')) {
                $table->string('temporary_token')->nullable();
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
