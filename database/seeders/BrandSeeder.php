<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BrandModel;
use App\Models\User;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    public function run()
    {
        // Get the admin user (assuming first user is admin)
        $admin = User::first();
        if (!$admin) {
            return;
        }

        $brands = [
            ['name' => 'Nike', 'slug' => Str::slug('Nike')],
            ['name' => 'Adidas', 'slug' => Str::slug('Adidas')],
            ['name' => 'Puma', 'slug' => Str::slug('Puma')],
            ['name' => 'Reebok', 'slug' => Str::slug('Reebok')],
            ['name' => 'New Balance', 'slug' => Str::slug('New Balance')],
            ['name' => 'Under Armour', 'slug' => Str::slug('Under Armour')],
            ['name' => 'Converse', 'slug' => Str::slug('Converse')],
            ['name' => 'Vans', 'slug' => Str::slug('Vans')],
            ['name' => 'Tommy Hilfiger', 'slug' => Str::slug('Tommy Hilfiger')],
            ['name' => 'Calvin Klein', 'slug' => Str::slug('Calvin Klein')],
            ['name' => 'Apple', 'slug' => Str::slug('Apple')],
            ['name' => 'Samsung', 'slug' => Str::slug('Samsung')],
            ['name' => 'Sony', 'slug' => Str::slug('Sony')],
            ['name' => 'LG', 'slug' => Str::slug('LG')],
            ['name' => 'Ikea', 'slug' => Str::slug('Ikea')],
            ['name' => 'Maybelline', 'slug' => Str::slug('Maybelline')],
            ['name' => 'L\'Oreal', 'slug' => Str::slug('L\'Oreal')],
        ];

        foreach ($brands as $brand) {
            BrandModel::firstOrCreate(
                ['name' => $brand['name']],
                [
                    'slug' => $brand['slug'],
                    'created_by' => $admin->id,
                    'is_delete' => 0,
                    'status' => 0,
                ]
            );
        }
    }
}
