<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAttachmentColumnToChattingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Only run if the chattings table exists
        if (Schema::hasTable('chattings')) {
                    Schema::table('chattings', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('chattings', 'attachment')) {
                $table->json('attachment')->after('message')->nullable();
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
        // Only run if the chattings table exists
        if (Schema::hasTable('chattings')) {
                    Schema::table('chattings', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('chattings', 'attachment')) {
                $table->dropColumn('attachment');
            }
        });
        }
    }
}
