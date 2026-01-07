<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSentByAndSendToInNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Only run if the notifications table exists
        if (Schema::hasTable('notifications')) {
                    Schema::table('notifications', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('notifications', 'sent_by')) {
                $table->string('sent_by')->after('id')->default('system');
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('notifications', 'sent_to')) {
                $table->string('sent_to')->after('sent_by')->default('customer');
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
        // Only run if the notifications table exists
        if (Schema::hasTable('notifications')) {
                    Schema::table('notifications', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('notifications', 'sent_to')) {
                $table->dropColumn('sent_to');
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('notifications', 'sent_by')) {
                $table->dropColumn('sent_by');
            }
        });
        }
    }
}
