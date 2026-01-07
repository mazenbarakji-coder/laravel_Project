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
        // Only run if the help_topics table exists
        if (Schema::hasTable('help_topics')) {
                    Schema::table('help_topics', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('help_topics', 'type')) {
                $table->string('type')->default('default')->after('id');
            }
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Only run if the help_topics table exists
        if (Schema::hasTable('help_topics')) {
                    Schema::table('help_topics', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('help_topics', 'type')) {
                $table->dropColumn('type');
            }
        });
        }
    }
};
