<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Main Dishes',
                'description' => 'Delicious main course meals including rice, noodles, and meat dishes.',
                'is_active' => true
            ],
            [
                'name' => 'Appetizers',
                'description' => 'Light and tasty starters to begin your meal.',
                'is_active' => true
            ],
            [
                'name' => 'Soups',
                'description' => 'Warm and comforting soups made with fresh ingredients.',
                'is_active' => true
            ],
            [
                'name' => 'Salads',
                'description' => 'Fresh and healthy salads with various dressings.',
                'is_active' => true
            ],
            [
                'name' => 'Desserts',
                'description' => 'Sweet treats and delicious desserts to end your meal.',
                'is_active' => true
            ],
            [
                'name' => 'Hot Drinks',
                'description' => 'Warm beverages including coffee, tea, and hot chocolate.',
                'is_active' => true
            ],
            [
                'name' => 'Cold Drinks',
                'description' => 'Refreshing cold beverages including juices, sodas, and iced drinks.',
                'is_active' => true
            ],
            [
                'name' => 'Alcoholic Beverages',
                'description' => 'Selection of beers, wines, and cocktails.',
                'is_active' => true
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
