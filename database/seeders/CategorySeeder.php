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
