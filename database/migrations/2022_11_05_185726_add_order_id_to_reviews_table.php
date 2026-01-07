<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrderIdToReviewsTable extends Migration
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
            if (!Schema::hasColumn('reviews', 'order_id')) {
                $table->bigInteger('order_id')->after('delivery_man_id')->nullable();
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('reviews', 'is_saved')) {
                $table->boolean('is_saved')->after('status')->default(0);
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
            Schema::dropIfExists('order_id');
            Schema::dropIfExists('is_saved');
        });
        }
    }
}
