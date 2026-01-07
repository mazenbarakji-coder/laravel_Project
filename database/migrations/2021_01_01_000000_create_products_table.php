<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Only create if the table doesn't exist
        if (!Schema::hasTable('products')) {
            Schema::create('products', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->nullable();
                $table->string('added_by')->nullable();
                $table->string('name');
                $table->string('code', 191)->nullable();
                $table->string('slug')->nullable();
                $table->text('category_ids')->nullable();
                $table->unsignedBigInteger('category_id')->nullable();
                $table->unsignedBigInteger('sub_category_id')->nullable();
                $table->unsignedBigInteger('sub_sub_category_id')->nullable();
                $table->unsignedBigInteger('brand_id')->nullable();
                $table->string('unit')->nullable();
                $table->string('digital_product_type')->nullable();
                $table->string('product_type')->nullable();
                $table->longText('details')->nullable();
                $table->text('colors')->nullable();
                $table->text('choice_options')->nullable();
                $table->text('variation')->nullable();
                $table->text('digital_product_file_types')->nullable();
                $table->text('digital_product_extensions')->nullable();
                $table->decimal('unit_price', 50, 2)->default(0);
                $table->decimal('purchase_price', 50, 2)->default(0);
                $table->string('tax')->nullable();
                $table->string('tax_type')->nullable();
                $table->string('tax_model')->nullable();
                $table->string('discount')->nullable();
                $table->string('discount_type')->nullable();
                $table->text('attributes')->nullable();
                $table->integer('current_stock')->default(0);
                $table->integer('minimum_order_qty')->default(1);
                $table->integer('min_qty')->default(1);
                $table->integer('free_shipping')->default(0);
                $table->integer('status')->default(1);
                $table->integer('featured_status')->default(0);
                $table->integer('featured')->default(0);
                $table->integer('request_status')->default(0);
                $table->integer('refundable')->default(0);
                $table->integer('flash_deal')->default(0);
                $table->unsignedBigInteger('seller_id')->nullable();
                $table->float('shipping_cost')->nullable();
                $table->boolean('multiply_qty')->nullable();
                $table->float('temp_shipping_cost')->nullable();
                $table->string('thumbnail')->nullable();
                $table->text('color_image')->nullable();
                $table->text('images')->nullable();
                $table->string('digital_file_ready')->nullable();
                $table->string('meta_title')->nullable();
                $table->string('meta_description')->nullable();
                $table->string('meta_image')->nullable();
                $table->boolean('is_shipping_cost_updated')->nullable();
                $table->integer('published')->default(0);
                $table->string('video_provider')->nullable();
                $table->string('video_url')->nullable();
                $table->string('thumbnail_storage_type')->nullable();
                $table->string('digital_file_ready_storage_type')->nullable();
                $table->timestamps();
            });
            
            // Add foreign keys if tables exist (must be done after table creation)
            // Note: Foreign keys are optional and may be added by other migrations
            // We skip adding them here to avoid conflicts if they're added later
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('products')) {
            Schema::dropIfExists('products');
        }
    }
}

