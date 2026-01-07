<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColToContact extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Only run if the contacts table exists
        if (Schema::hasTable('contacts')) {
            Schema::table('contacts', function (Blueprint $table) {
                // Check if column doesn't already exist
                if (!Schema::hasColumn('contacts', 'reply')) {
                    $table->longText('reply')->nullable();
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
        // Only run if the contacts table exists
        if (Schema::hasTable('contacts')) {
            Schema::table('contacts', function (Blueprint $table) {
                // Check if column exists before dropping
                if (Schema::hasColumn('contacts', 'reply')) {
                    $table->dropColumn(['reply']);
                }
            });
        }
    }
}
