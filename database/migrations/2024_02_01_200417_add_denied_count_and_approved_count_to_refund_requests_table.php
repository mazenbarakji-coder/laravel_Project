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
        // Only run if the refund_requests table exists
        if (Schema::hasTable('refund_requests')) {
                    Schema::table('refund_requests', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('refund_requests', 'approved_count')) {
                $table->tinyInteger('approved_count')->after('status')->default(0);
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('refund_requests', 'denied_count')) {
                $table->tinyInteger('denied_count')->after('approved_count')->default(0);
            }
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Only run if the refund_requests table exists
        if (Schema::hasTable('refund_requests')) {
                    Schema::table('refund_requests', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('refund_requests', 'approved_count')) {
                $table->dropColumn('approved_count');
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('refund_requests', 'denied_count')) {
                $table->dropColumn('denied_count');
            }
        });
        }
    }
};
