<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVisitCountToTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Only run if the tags table exists
        if (Schema::hasTable('tags')) {
                    Schema::table('tags', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('tags', 'visit_count')) {
                $table->bigInteger('visit_count')->after('tag')->default(0)->unsigned();
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
        // Only run if the tags table exists
        if (Schema::hasTable('tags')) {
                    Schema::table('tags', function (Blueprint $table) {
            Schema::dropIfExists('visit_count');
        });
        }
    }
}
