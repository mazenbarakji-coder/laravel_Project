<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAttachmentColumnToSupportTicketConvsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Only run if the support_ticket_convs table exists
        if (Schema::hasTable('support_ticket_convs')) {
                    Schema::table('support_ticket_convs', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('support_ticket_convs', 'attachment')) {
                $table->json('attachment')->after('customer_message')->nullable();
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
        // Only run if the support_ticket_convs table exists
        if (Schema::hasTable('support_ticket_convs')) {
                    Schema::table('support_ticket_convs', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('support_ticket_convs', 'attachment')) {
                $table->dropColumn('attachment');
            }
        });
        }
    }
}
