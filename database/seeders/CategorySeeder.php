<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CategoryModel;
use App\Models\User;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $admin = User::first();
        if (!$admin) {
            return;
        }

        $categories = [
            [
                'name' => 'Men\'s Clothing',
                'slug' => Str::slug('Men\'s Clothing'),
                'is_home' => 1,
                'is_menu' => 1,
                'button_name' => 'Shop Men\'s Collection',
            ],
            [
                'name' => 'Women\'s Clothing',
                'slug' => Str::slug('Women\'s Clothing'),
                'is_home' => 1,
                'is_menu' => 1,
                'button_name' => 'Shop Women\'s Collection',
            ],
            [
                'name' => 'Footwear',
                'slug' => Str::slug('Footwear'),
                'is_home' => 1,
                'is_menu' => 1,
                'button_name' => 'Shop Shoes',
            ],
            [
                'name' => 'Accessories',
                'slug' => Str::slug('Accessories'),
                'is_home' => 0,
                'is_menu' => 1,
                'button_name' => 'Shop Accessories',
            ],
            [
                'name' => 'Sports Wear',
                'slug' => Str::slug('Sports Wear'),
                'is_home' => 1,
                'is_menu' => 1,
                'button_name' => 'Shop Sports Wear',
            ],
            [
                'name' => 'Kids Clothing',
                'slug' => Str::slug('Kids Clothing'),
                'is_home' => 0,
                'is_menu' => 1,
                'button_name' => 'Shop Kids Collection',
            ],
            [
                'name' => 'Electronics',
                'slug' => Str::slug('Electronics'),
                'is_home' => 1,
                'is_menu' => 1,
                'button_name' => 'Shop Electronics',
            ],
            [
                'name' => 'Home & Garden',
                'slug' => Str::slug('Home & Garden'),
                'is_home' => 0,
                'is_menu' => 1,
                'button_name' => 'Shop Home & Garden',
            ],
            [
                'name' => 'Beauty & Health',
                'slug' => Str::slug('Beauty & Health'),
                'is_home' => 1,
                'is_menu' => 1,
                'button_name' => 'Shop Beauty',
            ],
        ];

        foreach ($categories as $category) {
            CategoryModel::firstOrCreate(
                ['name' => $category['name']],
                [
                    'slug' => $category['slug'],
                    'button_name' => $category['button_name'],
                    'is_home' => $category['is_home'],
                    'is_menu' => $category['is_menu'],
                    'created_by' => $admin->id,
                    'is_delete' => 0,
                    'status' => 0,
                ]
            );
        }
    }
}
