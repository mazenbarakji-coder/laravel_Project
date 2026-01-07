<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLoginHitCountAndIsTempBlockedAndTempBlockTimeToPasswordResetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Only run if the password_resets table exists
        if (Schema::hasTable('password_resets')) {
                    Schema::table('password_resets', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('password_resets', 'otp_hit_count')) {
                $table->tinyInteger('otp_hit_count')->default('0')->after('token');
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('password_resets', 'is_temp_blocked')) {
                $table->boolean('is_temp_blocked')->default('0')->after('otp_hit_count');
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('password_resets', 'temp_block_time')) {
                $table->timestamp('temp_block_time')->nullable()->after('is_temp_blocked');
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
        // Only run if the password_resets table exists
        if (Schema::hasTable('password_resets')) {
                    Schema::table('password_resets', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('password_resets', 'otp_hit_count')) {
                $table->dropColumn('otp_hit_count');
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('password_resets', 'is_temp_blocked')) {
                $table->dropColumn('is_temp_blocked');
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('password_resets', 'temp_block_time')) {
                $table->dropColumn('temp_block_time');
            }
        });
        }
    }
}
