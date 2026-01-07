<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNotificationCountToNotificationsTable extends Migration
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
            if (!Schema::hasColumn('notifications', 'notification_count')) {
                $table->integer('notification_count')->after('description')->default(0);
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
            if (!Schema::hasColumn('notifications', 'notification_count')) {
                $table->dropColumn('notification_count');
            }
        });
        }
    }
}
