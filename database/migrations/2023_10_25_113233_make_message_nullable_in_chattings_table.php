<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeMessageNullableInChattingsTable extends Migration
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
            // Check if column exists before changing
            if (Schema::hasColumn('chattings', 'message')) {
                $table->text('message')->nullable()->change();
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
            // Check if column exists before changing
            if (Schema::hasColumn('chattings', 'message')) {
                $table->text('message')->change();
            }
        });
        }
    }
}
