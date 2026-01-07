<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExpiresAtToPasswordResets extends Migration
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
            $table->id();
            // Check if column doesn't already exist
            if (!Schema::hasColumn('password_resets', 'expires_at')) {
                $table->timestamp('expires_at')->after('token')->nullable();
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('password_resets', 'updated_at')) {
                $table->timestamp('updated_at')->after('created_at')->nullable();
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
            if (!Schema::hasColumn('password_resets', 'id')) {
                $table->dropIfExists('id');
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('password_resets', 'expires_at')) {
                $table->dropIfExists('expires_at');
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('password_resets', 'updated_at')) {
                $table->dropIfExists('updated_at');
            }
        });
        }
    }
}
