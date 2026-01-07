<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAttachmentToSupportTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Only run if the support_tickets table exists
        if (Schema::hasTable('support_tickets')) {
                    Schema::table('support_tickets', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('support_tickets', 'attachment')) {
                $table->json('attachment')->after('description')->nullable();
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
        // Only run if the support_tickets table exists
        if (Schema::hasTable('support_tickets')) {
                    Schema::table('support_tickets', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('support_tickets', 'attachment')) {
                $table->dropColumn('attachment');
            }
        });
        }
    }
}
