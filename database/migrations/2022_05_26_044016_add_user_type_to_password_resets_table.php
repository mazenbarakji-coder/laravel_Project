<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserTypeToPasswordResetsTable extends Migration
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
            if (!Schema::hasColumn('password_resets', 'user_type')) {
                $table->string('user_type')->default('customer');
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
            if (!Schema::hasColumn('password_resets', 'user_type')) {
                $table->dropColumn('user_type');
            }
        });
        }
    }
}
