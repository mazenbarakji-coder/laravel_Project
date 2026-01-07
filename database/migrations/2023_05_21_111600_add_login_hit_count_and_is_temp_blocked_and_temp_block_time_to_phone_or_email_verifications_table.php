<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLoginHitCountAndIsTempBlockedAndTempBlockTimeToPhoneOrEmailVerificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Only run if the phone_or_email_verifications table exists
        if (Schema::hasTable('phone_or_email_verifications')) {
                    Schema::table('phone_or_email_verifications', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('phone_or_email_verifications', 'otp_hit_count')) {
                $table->tinyInteger('otp_hit_count')->default('0')->after('token');
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('phone_or_email_verifications', 'is_temp_blocked')) {
                $table->boolean('is_temp_blocked')->default('0')->after('otp_hit_count');
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('phone_or_email_verifications', 'temp_block_time')) {
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
        // Only run if the phone_or_email_verifications table exists
        if (Schema::hasTable('phone_or_email_verifications')) {
                    Schema::table('phone_or_email_verifications', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('phone_or_email_verifications', 'otp_hit_count')) {
                $table->dropColumn('otp_hit_count');
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('phone_or_email_verifications', 'is_temp_blocked')) {
                $table->dropColumn('is_temp_blocked');
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('phone_or_email_verifications', 'temp_block_time')) {
                $table->dropColumn('temp_block_time');
            }
        });
        }
    }
}
