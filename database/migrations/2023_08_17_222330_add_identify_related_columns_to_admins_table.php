<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdentifyRelatedColumnsToAdminsTable extends Migration
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
            if (!Schema::hasColumn('admins', 'identify_image')) {
                $table->text('identify_image')->nullable()->after('image');
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('admins', 'identify_type')) {
                $table->string('identify_type')->nullable()->after('identify_image');
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('admins', 'identify_number')) {
                $table->integer('identify_number')->nullable()->after('identify_type');
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
            if (!Schema::hasColumn('admins', 'identify_image')) {
                $table->text('identify_image');
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('admins', 'identify_type')) {
                $table->string('identify_type');
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('admins', 'identify_number')) {
                $table->integer('identify_number');
            }
        });
        }
    }
}
