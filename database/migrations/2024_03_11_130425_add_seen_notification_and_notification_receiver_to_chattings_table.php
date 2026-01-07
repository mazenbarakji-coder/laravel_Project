<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Only run if the chattings table exists
        if (Schema::hasTable('chattings')) {
                    Schema::table('chattings', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('chattings', 'seen_notification')) {
                $table->boolean('seen_notification')->after('status')->default(0)->nullable();
            }
            $table->string('notification_receiver', 20)->after('status')->nullable()->comment('admin, seller, customer, deliveryman');
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Only run if the chattings table exists
        if (Schema::hasTable('chattings')) {
                    Schema::table('chattings', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('chattings', 'seen_notification')) {
                $table->dropColumn('seen_notification');
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('chattings', 'notification_receiver')) {
                $table->dropColumn('notification_receiver');
            }
        });
        }
    }
};
