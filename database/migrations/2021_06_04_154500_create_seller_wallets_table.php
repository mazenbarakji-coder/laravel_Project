<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellerWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Only create if it doesn't already exist
        if (!Schema::hasTable('seller_wallets')) {
            Schema::create('seller_wallets', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('seller_id')->nullable();
                $table->decimal('balance', 50, 2)->default(0);
                $table->decimal('withdrawn', 50, 2)->default(0);
                $table->timestamps();
            });
            
            // Add foreign key only if sellers table exists
            if (Schema::hasTable('sellers')) {
                Schema::table('seller_wallets', function (Blueprint $table) {
                    $table->foreign('seller_id')->references('id')->on('sellers')->onDelete('cascade');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seller_wallets');
    }
}

