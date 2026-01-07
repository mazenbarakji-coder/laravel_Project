<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLoginHitCountAndIsTempBlockedAndTempBlockTimeToUsersTable extends Migration
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
            if (!Schema::hasColumn('users', 'login_hit_count')) {
                $table->tinyInteger('login_hit_count')->default(0);
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('users', 'is_temp_blocked')) {
                $table->boolean('is_temp_blocked')->default(0);
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('users', 'temp_block_time')) {
                $table->timestamp('temp_block_time')->nullable();
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
            if (!Schema::hasColumn('users', 'login_hit_count')) {
                $table->dropColumn('login_hit_count');
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('users', 'is_temp_blocked')) {
                $table->dropColumn('is_temp_blocked');
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('users', 'temp_block_time')) {
                $table->dropColumn('temp_block_time');
            }
        });
        }
    }
}
