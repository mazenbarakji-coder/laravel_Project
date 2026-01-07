<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTaxModelToProductsTable extends Migration
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
            $table->string('tax_model', 20)->after('tax_type')->default('exclude');
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
            Schema::dropIfExists('tax_model');
        });
        }
    }
}
