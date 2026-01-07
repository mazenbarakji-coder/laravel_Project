<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeAttachmentColumnTypeChangeToReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Only run if the reviews table exists
        if (Schema::hasTable('reviews')) {
                    Schema::table('reviews', function (Blueprint $table) {
            // Check if column exists before changing
            if (Schema::hasColumn('reviews', 'attachment')) {
                $table->json('attachment')->change()->nullable();
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
        // Only run if the reviews table exists
        if (Schema::hasTable('reviews')) {
                    Schema::table('reviews', function (Blueprint $table) {
            // Check if column exists before changing
            if (Schema::hasColumn('reviews', 'attachment')) {
                $table->string('attachment')->change()->nullable();
            }
        });
        }
    }
}
