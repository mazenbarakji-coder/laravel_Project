<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColTypeTranslation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Only run if the translations table exists
        if (Schema::hasTable('translations')) {
                    Schema::table('translations', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('translations', 'id')) {
                $table->dropColumn('id');
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
        // Only run if the translations table exists
        if (Schema::hasTable('translations')) {
                    Schema::table('translations', function (Blueprint $table) {
            //
        });
        }
    }
}
