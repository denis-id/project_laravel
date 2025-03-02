<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Cappuccino Espresso',
                'description' => 'Cappuccino Espresso desc.',
                'price' => 24000,
                'category_id' => 1,
                'images' => ['products/1.jpg'],
                'is_active' => true,
                'variants' => [
                    ['size' => 'small', 'stock' => 100],
                    ['size' => 'medium', 'stock' => 50],
                    ['size' => 'large', 'stock' => 30],
                ]
            ],
            [
                'name' => 'Americano',
                'description' => 'Americano desc.',
                'price' => 20000,
                'category_id' => 2,
                'images' => ['products/2.jpg'],
                'is_active' => true,
                'variants' => [
                    ['size' => 'small', 'stock' => 120],
                    ['size' => 'medium', 'stock' => 80],
                    ['size' => 'large', 'stock' => 60],
                ]
            ],
            [
                'name' => 'Espresso Coffee',
                'description' => 'Espresso Coffee desc.',
                'price' => 20000,
                'category_id' => 3,
                'images' => ['products/3.jpg'],
                'is_active' => false,
                'variants' => [] 
            ]
        ];

        foreach ($products as $productData) {
            $product = Product::create([
                'name' => $productData['name'],
                'description' => $productData['description'],
                'price' => $productData['price'],
                'category_id' => $productData['category_id'],
                'images' => json_encode($productData['images']),
                'is_active' => $productData['is_active'],
            ]);

            if (!empty($productData['variants'])) {
                
                foreach ($productData['variants'] as $variant) {
                    ProductVariant::create([
                        'product_id' => $product->id,
                        'variant_name' => $variant['size'] . ' size',
                        'stock' => $variant['stock'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}