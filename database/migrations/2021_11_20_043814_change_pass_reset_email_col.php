<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangePassResetEmailCol extends Migration
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
            $table->renameColumn('email', 'identity');
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
            //
        });
        }
    }
}
