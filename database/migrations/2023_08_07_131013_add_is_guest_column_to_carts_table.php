<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsGuestColumnToCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Only run if the carts table exists
        if (Schema::hasTable('carts')) {
                    Schema::table('carts', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('carts', 'is_guest')) {
                $table->tinyInteger('is_guest')->default(0);
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
        // Only run if the carts table exists
        if (Schema::hasTable('carts')) {
                    Schema::table('carts', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('carts', 'is_guest')) {
                $table->dropColumn('is_guest');
            }
        });
        }
    }
}
