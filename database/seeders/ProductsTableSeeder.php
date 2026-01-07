<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Example: Seed sample products
        // Adjust columns based on your actual products table structure
        
        DB::table('products')->insert([
            'name' => 'Sample Product',
            'slug' => Str::slug('Sample Product'),
            'product_type' => 'physical',
            'category_ids' => json_encode([1]),
            'unit_price' => 100.00,
            'purchase_price' => 80.00,
            'tax' => 10.00,
            'tax_model' => 'exclude',
            'discount' => 0,
            'discount_type' => 'flat',
            'quantity' => 100,
            'sku' => 'SKU-' . Str::random(8),
            'status' => 1,
            'request_status' => 1,
            'added_by' => 'admin',
            'user_id' => 1,
            'images' => json_encode(['def.png']),
            'thumbnail' => 'def.png',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Uncomment and modify to seed more products:
        /*
        for ($i = 1; $i <= 10; $i++) {
            DB::table('products')->insert([
                'name' => 'Product ' . $i,
                'slug' => Str::slug('Product ' . $i),
                'product_type' => 'physical',
                'category_ids' => json_encode([1]),
                'unit_price' => rand(50, 500),
                'purchase_price' => rand(30, 400),
                'tax' => 10.00,
                'tax_model' => 'exclude',
                'discount' => 0,
                'discount_type' => 'flat',
                'quantity' => rand(10, 200),
                'sku' => 'SKU-' . Str::random(8),
                'status' => 1,
                'request_status' => 1,
                'added_by' => 'admin',
                'user_id' => 1,
                'images' => json_encode(['def.png']),
                'thumbnail' => 'def.png',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        */
    }
}




