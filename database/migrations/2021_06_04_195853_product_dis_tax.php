<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProductDisTax extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Only run if the products table exists
        if (Schema::hasTable('products')) {
            Schema::table('products', function (Blueprint $table) {
                // Check if columns exist before changing
                if (Schema::hasColumn('products', 'discount')) {
                    $table->string('discount')->change();
                }
                if (Schema::hasColumn('products', 'tax')) {
                    $table->string('tax')->change();
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
        // Only run if the products table exists
        if (Schema::hasTable('products')) {
            Schema::table('products', function (Blueprint $table) {
                // Revert column type changes if needed
                if (Schema::hasColumn('products', 'discount')) {
                    // Note: Reverting string changes may require specific handling
                    // Adjust based on your original column type
                }
                if (Schema::hasColumn('products', 'tax')) {
                    // Note: Reverting string changes may require specific handling
                    // Adjust based on your original column type
                }
            });
        }
    }
}
