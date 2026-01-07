<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ExRateUpdate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Only run if the currencies table exists
        if (Schema::hasTable('currencies')) {
            Schema::table('currencies', function (Blueprint $table) {
                // Check if column exists before changing
                if (Schema::hasColumn('currencies', 'exchange_rate')) {
                    $table->string('exchange_rate')->change();
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
        // Only run if the currencies table exists
        if (Schema::hasTable('currencies')) {
            Schema::table('currencies', function (Blueprint $table) {
                // Revert column type change if needed
                if (Schema::hasColumn('currencies', 'exchange_rate')) {
                    // Note: Reverting string changes may require specific handling
                    // Adjust based on your original column type
                }
            });
        }
    }
}
