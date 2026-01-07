<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Only run if the admins table exists
        if (Schema::hasTable('admins')) {
                    Schema::table('admins', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('admins', 'status')) {
                $table->boolean('status')->default(1);
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
        // Only run if the admins table exists
        if (Schema::hasTable('admins')) {
                    Schema::table('admins', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('admins', 'status')) {
                $table->dropColumn('status');
            }
        });
        }
    }
}
