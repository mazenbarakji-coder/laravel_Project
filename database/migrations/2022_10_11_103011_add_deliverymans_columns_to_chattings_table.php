<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeliverymansColumnsToChattingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Only run if the chattings table exists
        if (Schema::hasTable('chattings')) {
                    Schema::table('chattings', function (Blueprint $table) {
            // Check if column exists before changing
            if (Schema::hasColumn('chattings', 'user_id')) {
                $table->bigInteger('user_id')->nullable()->change();
            }
            // Check if column exists before changing
            if (Schema::hasColumn('chattings', 'seller_id')) {
                $table->bigInteger('seller_id')->nullable()->change();
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('chattings', 'delivery_man_id')) {
                $table->bigInteger('delivery_man_id')->nullable()->after('seller_id');
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('chattings', 'admin_id')) {
                $table->bigInteger('admin_id')->nullable()->after('seller_id');
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('chattings', 'sent_by_delivery_man')) {
                $table->boolean('sent_by_delivery_man')->nullable()->after('sent_by_seller');
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('chattings', 'sent_by_admin')) {
                $table->boolean('sent_by_admin')->nullable()->after('sent_by_seller');
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('chattings', 'seen_by_delivery_man')) {
                $table->boolean('seen_by_delivery_man')->nullable()->after('seen_by_seller');
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('chattings', 'seen_by_admin')) {
                $table->boolean('seen_by_admin')->nullable()->after('seen_by_seller');
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
        // Only run if the chattings table exists
        if (Schema::hasTable('chattings')) {
                    Schema::table('chattings', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('chattings', 'user_id')) {
                $table->dropColumn('user_id');
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('chattings', 'seller_id')) {
                $table->dropColumn('seller_id');
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('chattings', 'delivery_man_id')) {
                $table->dropColumn('delivery_man_id');
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('chattings', 'admin_id')) {
                $table->dropColumn('admin_id');
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('chattings', 'sent_by_delivery_man')) {
                $table->dropColumn('sent_by_delivery_man');
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('chattings', 'sent_by_admin')) {
                $table->dropColumn('sent_by_admin');
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('chattings', 'seen_by_delivery_man')) {
                $table->dropColumn('seen_by_delivery_man');
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('chattings', 'seen_by_admin')) {
                $table->dropColumn('seen_by_admin');
            }
        });
        }
    }
}
