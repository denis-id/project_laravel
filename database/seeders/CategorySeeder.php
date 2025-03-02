<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'House Blend Coffee', 
                'description' => 'A classic mix of arabica beans', 
                'is_active' => true
            ],
            [
                'name' => 'Traditional Coffee', 
                'description' => 'Rich and authentic traditional coffee', 
                'is_active' => true
            ],
            [
                'name' => 'Non Coffee', 
                'description' => 'Delicious beverages without coffee', 
                'is_active' => true
            ],
            [
                'name' => 'Dessert', 
                'description' => 'Sweet and delightful desserts', 
                'is_active' => true
            ],
            [
                'name' => 'Japan Appetizer', 
                'description' => 'Savory starters inspired by Japanese cuisine', 
                'is_active' => true
            ]
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate([
                'name' => $category['name']
            ], [
                'description' => $category['description'],
                'is_active' => $category['is_active']
            ]);
        }
    }
}