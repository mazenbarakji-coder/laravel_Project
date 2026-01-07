<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDelivermanIdCloumnToReviewsTable extends Migration
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
            // Check if column doesn't already exist
            if (!Schema::hasColumn('reviews', 'delivery_man_id')) {
                $table->bigInteger('delivery_man_id')->nullable()->after('customer_id');
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
            // Check if column doesn't already exist
            if (!Schema::hasColumn('reviews', 'delivery_man_id')) {
                $table->dropColumn('delivery_man_id');
            }
        });
        }
    }
}
