<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeCartColType extends Migration
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
            // Check if column exists before changing
            if (Schema::hasColumn('carts', 'price')) {
                $table->float('price')->change();
            }
            // Check if column exists before changing
            if (Schema::hasColumn('carts', 'tax')) {
                $table->float('tax')->change();
            }
            // Check if column exists before changing
            if (Schema::hasColumn('carts', 'discount')) {
                $table->float('discount')->change();
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
            //
        });
        }
    }
}
