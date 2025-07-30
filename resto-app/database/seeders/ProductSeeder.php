<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            // Main Dishes
            [
                'name' => 'Grilled Chicken Rice',
                'description' => 'Tender grilled chicken served with fragrant rice and vegetables.',
                'price' => 12.99,
                'category_name' => 'Main Dishes',
                'type' => 'food',
                'is_available' => true
            ],
            [
                'name' => 'Beef Noodles',
                'description' => 'Rich beef broth with tender beef slices and fresh noodles.',
                'price' => 14.99,
                'category_name' => 'Main Dishes',
                'type' => 'food',
                'is_available' => true
            ],
            [
                'name' => 'Fish Curry',
                'description' => 'Spicy fish curry with coconut milk and aromatic spices.',
                'price' => 16.99,
                'category_name' => 'Main Dishes',
                'type' => 'food',
                'is_available' => true
            ],
            
            // Appetizers
            [
                'name' => 'Spring Rolls',
                'description' => 'Crispy spring rolls filled with vegetables and served with sweet chili sauce.',
                'price' => 6.99,
                'category_name' => 'Appetizers',
                'type' => 'food',
                'is_available' => true
            ],
            [
                'name' => 'Chicken Wings',
                'description' => 'Crispy fried chicken wings with your choice of sauce.',
                'price' => 8.99,
                'category_name' => 'Appetizers',
                'type' => 'food',
                'is_available' => true
            ],
            
            // Soups
            [
                'name' => 'Tom Yum Soup',
                'description' => 'Spicy and sour soup with shrimp, mushrooms, and lemongrass.',
                'price' => 9.99,
                'category_name' => 'Soups',
                'type' => 'food',
                'is_available' => true
            ],
            [
                'name' => 'Chicken Noodle Soup',
                'description' => 'Comforting chicken soup with vegetables and egg noodles.',
                'price' => 7.99,
                'category_name' => 'Soups',
                'type' => 'food',
                'is_available' => true
            ],
            
            // Salads
            [
                'name' => 'Caesar Salad',
                'description' => 'Fresh romaine lettuce with Caesar dressing, croutons, and parmesan cheese.',
                'price' => 8.99,
                'category_name' => 'Salads',
                'type' => 'food',
                'is_available' => true
            ],
            [
                'name' => 'Thai Papaya Salad',
                'description' => 'Spicy green papaya salad with peanuts and lime dressing.',
                'price' => 7.99,
                'category_name' => 'Salads',
                'type' => 'food',
                'is_available' => true
            ],
            
            // Desserts
            [
                'name' => 'Chocolate Cake',
                'description' => 'Rich chocolate cake with chocolate ganache frosting.',
                'price' => 5.99,
                'category_name' => 'Desserts',
                'type' => 'food',
                'is_available' => true
            ],
            [
                'name' => 'Ice Cream',
                'description' => 'Vanilla ice cream with your choice of toppings.',
                'price' => 4.99,
                'category_name' => 'Desserts',
                'type' => 'food',
                'is_available' => true
            ],
            
            // Hot Drinks
            [
                'name' => 'Coffee',
                'description' => 'Freshly brewed coffee served hot.',
                'price' => 3.99,
                'category_name' => 'Hot Drinks',
                'type' => 'drink',
                'is_available' => true
            ],
            [
                'name' => 'Green Tea',
                'description' => 'Traditional green tea served hot.',
                'price' => 2.99,
                'category_name' => 'Hot Drinks',
                'type' => 'drink',
                'is_available' => true
            ],
            [
                'name' => 'Hot Chocolate',
                'description' => 'Rich hot chocolate with whipped cream.',
                'price' => 4.99,
                'category_name' => 'Hot Drinks',
                'type' => 'drink',
                'is_available' => true
            ],
            
            // Cold Drinks
            [
                'name' => 'Orange Juice',
                'description' => 'Freshly squeezed orange juice.',
                'price' => 3.99,
                'category_name' => 'Cold Drinks',
                'type' => 'drink',
                'is_available' => true
            ],
            [
                'name' => 'Iced Tea',
                'description' => 'Refreshing iced tea with lemon.',
                'price' => 2.99,
                'category_name' => 'Cold Drinks',
                'type' => 'drink',
                'is_available' => true
            ],
            [
                'name' => 'Soda',
                'description' => 'Your choice of carbonated soft drinks.',
                'price' => 2.49,
                'category_name' => 'Cold Drinks',
                'type' => 'drink',
                'is_available' => true
            ],
            
            // Alcoholic Beverages
            [
                'name' => 'Beer',
                'description' => 'Local and imported beers available.',
                'price' => 5.99,
                'category_name' => 'Alcoholic Beverages',
                'type' => 'drink',
                'is_available' => true
            ],
            [
                'name' => 'Wine',
                'description' => 'Selection of red and white wines.',
                'price' => 8.99,
                'category_name' => 'Alcoholic Beverages',
                'type' => 'drink',
                'is_available' => true
            ]
        ];

        foreach ($products as $product) {
            $category = Category::where('name', $product['category_name'])->first();
            if ($category) {
                Product::create([
                    'name' => $product['name'],
                    'description' => $product['description'],
                    'price' => $product['price'],
                    'category_id' => $category->id,
                    'type' => $product['type'],
                    'is_available' => $product['is_available']
                ]);
            }
        }
    }
}
