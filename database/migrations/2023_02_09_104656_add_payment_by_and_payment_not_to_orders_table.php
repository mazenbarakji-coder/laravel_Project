<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentByAndPaymentNotToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Only run if the orders table exists
        if (Schema::hasTable('orders')) {
                    Schema::table('orders', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('orders', 'payment_by')) {
                $table->string('payment_by')->after('transaction_ref')->nullable();
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('orders', 'payment_note')) {
                $table->text('payment_note')->after('payment_by')->nullable();
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
        // Only run if the orders table exists
        if (Schema::hasTable('orders')) {
                    Schema::table('orders', function (Blueprint $table) {
            Schema::dropIfExists('payment_by');
            Schema::dropIfExists('payment_note');
        });
        }
    }
}
