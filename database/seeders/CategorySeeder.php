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
                'name' => 'Newborn (0-12 months)',
                'slug' => Str::slug('Newborn (0-12 months)'),
                'is_home' => 1,
                'is_menu' => 1,
                'button_name' => 'Shop Newborn',
            ],
            [
                'name' => 'Baby (1-3 years)',
                'slug' => Str::slug('Baby (1-3 years)'),
                'is_home' => 1,
                'is_menu' => 1,
                'button_name' => 'Shop Baby',
            ],
            [
                'name' => 'Toddler (3-5 years)',
                'slug' => Str::slug('Toddler (3-5 years)'),
                'is_home' => 1,
                'is_menu' => 1,
                'button_name' => 'Shop Toddler',
            ],
            [
                'name' => 'Kids (5-7 years)',
                'slug' => Str::slug('Kids (5-7 years)'),
                'is_home' => 1,
                'is_menu' => 1,
                'button_name' => 'Shop Kids',
            ],
            [
                'name' => 'Big Kids (8-12 years)',
                'slug' => Str::slug('Big Kids (8-12 years)'),
                'is_home' => 1,
                'is_menu' => 1,
                'button_name' => 'Shop Big Kids',
            ],
            [
                'name' => 'Teens (13-16 years)',
                'slug' => Str::slug('Teens (13-16 years)'),
                'is_home' => 1,
                'is_menu' => 1,
                'button_name' => 'Shop Teens',
            ],
            [
                'name' => 'Women',
                'slug' => Str::slug('Women'),
                'is_home' => 1,
                'is_menu' => 1,
                'button_name' => 'Shop Women',
            ],
            [
                'name' => 'Men',
                'slug' => Str::slug('Men'),
                'is_home' => 1,
                'is_menu' => 1,
                'button_name' => 'Shop Men',
            ],
            [
                'name' => 'Home & Living',
                'slug' => Str::slug('Home & Living'),
                'is_home' => 1,
                'is_menu' => 1,
                'button_name' => 'Shop Home',
            ],
            [
                'name' => 'Electronics',
                'slug' => Str::slug('Electronics'),
                'is_home' => 1,
                'is_menu' => 1,
                'button_name' => 'Shop Electronics',
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
