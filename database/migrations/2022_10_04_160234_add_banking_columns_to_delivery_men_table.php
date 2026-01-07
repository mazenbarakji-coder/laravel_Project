<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBankingColumnsToDeliveryMenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Only run if the delivery_men table exists
        if (Schema::hasTable('delivery_men')) {
                    Schema::table('delivery_men', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('delivery_men', 'holder_name')) {
                $table->string('holder_name')->nullable()->after('password');
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('delivery_men', 'account_no')) {
                $table->string('account_no')->nullable()->after('password');
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('delivery_men', 'branch')) {
                $table->string('branch')->nullable()->after('password');
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('delivery_men', 'bank_name')) {
                $table->string('bank_name')->nullable()->after('password');
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
        // Only run if the delivery_men table exists
        if (Schema::hasTable('delivery_men')) {
                    Schema::table('delivery_men', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('delivery_men', 'holder_name')) {
                $table->dropColumn('holder_name')->nullable();
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('delivery_men', 'account_no')) {
                $table->dropColumn('account_no')->nullable();
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('delivery_men', 'branch')) {
                $table->dropColumn('branch')->nullable();
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('delivery_men', 'bank_name')) {
                $table->dropColumn('bank_name')->nullable();
            }
        });
        }
    }
}
