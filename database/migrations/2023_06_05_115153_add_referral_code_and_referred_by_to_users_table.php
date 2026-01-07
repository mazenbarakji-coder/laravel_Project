<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReferralCodeAndReferredByToUsersTable extends Migration
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
            if (!Schema::hasColumn('users', 'referral_code')) {
                $table->string('referral_code')->after('temp_block_time')->nullable();
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('users', 'referred_by')) {
                $table->integer('referred_by')->after('referral_code')->nullable();
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
            if (!Schema::hasColumn('users', 'referral_code')) {
                $table->dropColumn('referral_code');
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('users', 'referred_by')) {
                $table->dropColumn('referred_by');
            }
        });
        }
    }
}
