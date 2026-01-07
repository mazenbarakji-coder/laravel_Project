<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProvider extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('oauth_clients', 'provider')) {
        // Only run if the oauth_clients table exists
        if (Schema::hasTable('oauth_clients')) {
                        Schema::table('oauth_clients', function (Blueprint $table) {
                // Check if column doesn't already exist
                if (!Schema::hasColumn('oauth_clients', 'provider')) {
                    $table->string('provider')->nullable();
                }
            });
        }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Only run if the oauth_clients table exists
        if (Schema::hasTable('oauth_clients')) {
                    Schema::table('oauth_clients', function (Blueprint $table) {
            //
        });
        }
    }
}
