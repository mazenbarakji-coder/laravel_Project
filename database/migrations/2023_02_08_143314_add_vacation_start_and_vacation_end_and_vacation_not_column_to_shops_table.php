<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVacationStartAndVacationEndAndVacationNotColumnToShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Only run if the shops table exists
        if (Schema::hasTable('shops')) {
                    Schema::table('shops', function (Blueprint $table) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('shops', 'vacation_start_date')) {
                $table->date('vacation_start_date')->after('image')->nullable();
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('shops', 'vacation_end_date')) {
                $table->date('vacation_end_date')->after('vacation_start_date')->nullable();
            }
            $table->string('vacation_note', 255)->after('vacation_end_date')->nullable();
            // Check if column doesn't already exist
            if (!Schema::hasColumn('shops', 'vacation_status')) {
                $table->tinyInteger('vacation_status')->after('vacation_note')->default(0);
            }
            // Check if column doesn't already exist
            if (!Schema::hasColumn('shops', 'temporary_close')) {
                $table->tinyInteger('temporary_close')->after('vacation_status')->default(0);
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
        // Only run if the shops table exists
        if (Schema::hasTable('shops')) {
                    Schema::table('shops', function (Blueprint $table) {
            Schema::dropIfExists('vacation_start_date');
            Schema::dropIfExists('vacation_end_date');
            Schema::dropIfExists('vacation_note');
            Schema::dropIfExists('vacation_status');
            Schema::dropIfExists('temporary_close');
        });
        }
    }
}
