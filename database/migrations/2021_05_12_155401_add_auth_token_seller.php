<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAuthTokenSeller extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Only run if the sellers table exists
        if (Schema::hasTable('sellers')) {
            Schema::table('sellers', function (Blueprint $table) {
                // Check if column doesn't already exist
                if (!Schema::hasColumn('sellers', 'auth_token')) {
                    $table->text('auth_token')->nullable();
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
        // Only run if the sellers table exists
        if (Schema::hasTable('sellers')) {
            Schema::table('sellers', function (Blueprint $table) {
                // Check if column exists before dropping
                if (Schema::hasColumn('sellers', 'auth_token')) {
                    $table->dropColumn(['auth_token']);
                }
            });
        }
    }
}
