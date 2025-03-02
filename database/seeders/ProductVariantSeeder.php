<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductVariant;

class ProductVariantSeeder extends Seeder
{
    public function run(): void
    {
    $variants = [
            [
                'product_id' => 1, 
                'variant_name' => 'small size', 
                'size' => 'small',
                'stock' => 100
            ],
            [
                'product_id' => 2, 
                'variant_name' => 'medium size',
                'size' => 'medium',
                'stock' => 70],
            [
                'product_id' => 3, 
                'variant_name' => 'big size', 
                'size' => 'big',
                'stock' => 50
            ],
        ];

        foreach ($variants as $variant) {
            ProductVariant::create($variant);
        }
    }
}