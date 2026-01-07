<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddActiveColUserTable extends Migration
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
                if (!Schema::hasColumn('users', 'is_active')) {
                    $table->boolean('is_active')->default(1);
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
                if (Schema::hasColumn('users', 'is_active')) {
                    $table->dropColumn(['is_active']);
                }
            });
        }
    }
}
