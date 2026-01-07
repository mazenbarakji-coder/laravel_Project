<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPublishToProductsTable extends Migration
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
            // Check if column doesn't already exist
            if (!Schema::hasColumn('products', 'request_status')) {
                $table->boolean('request_status')->default(0);
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('products', 'denied_note')) {
                $table->string('denied_note')->nullable();
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
            // Check if column doesn't already exist
            if (!Schema::hasColumn('products', 'request_status')) {
                $table->dropColumn('request_status');
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('products', 'denied_note')) {
                $table->dropColumn('denied_note');
            }
        });
        }
    }
}
