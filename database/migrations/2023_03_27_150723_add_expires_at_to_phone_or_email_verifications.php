<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExpiresAtToPhoneOrEmailVerifications extends Migration
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
            if (!Schema::hasColumn('phone_or_email_verifications', 'expires_at')) {
                $table->timestamp('expires_at')->after('token')->nullable();
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
            if (!Schema::hasColumn('phone_or_email_verifications', 'expires_at')) {
                $table->dropIfExists('expires_at');
            }
        });
        }
    }
}
