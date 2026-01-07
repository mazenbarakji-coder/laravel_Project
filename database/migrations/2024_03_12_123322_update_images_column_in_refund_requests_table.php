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
            // Check if column exists before changing
            if (Schema::hasColumn('refund_requests', 'images')) {
                $table->text('images')->nullable()->change();
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
            // Check if column exists before changing
            if (Schema::hasColumn('refund_requests', 'images')) {
                $table->string('images')->nullable()->change();
            }
        });
        }
    }
};
