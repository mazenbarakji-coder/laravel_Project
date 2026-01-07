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
        // Only run if the emergency_contacts table exists
        if (Schema::hasTable('emergency_contacts')) {
                    Schema::table('emergency_contacts', function (Blueprint $table) {
            $table->string('country_code', 20)->after('name')->nullable();
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Only run if the emergency_contacts table exists
        if (Schema::hasTable('emergency_contacts')) {
                    Schema::table('emergency_contacts', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('emergency_contacts', 'country_code')) {
                $table->dropColumn('country_code');
            }
        });
        }
    }
};
