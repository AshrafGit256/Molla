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
            ['name' => 'Carter\'s', 'slug' => Str::slug('Carter\'s')],
            ['name' => 'Gerber', 'slug' => Str::slug('Gerber')],
            ['name' => 'H&M Kids', 'slug' => Str::slug('H&M Kids')],
            ['name' => 'Gap Kids', 'slug' => Str::slug('Gap Kids')],
            ['name' => 'Old Navy Kids', 'slug' => Str::slug('Old Navy Kids')],
            ['name' => 'Zara Kids', 'slug' => Str::slug('Zara Kids')],
            ['name' => 'Crocs Kids', 'slug' => Str::slug('Crocs Kids')],
            ['name' => 'Nike Kids', 'slug' => Str::slug('Nike Kids')],
            ['name' => 'Adidas Kids', 'slug' => Str::slug('Adidas Kids')],
            ['name' => 'Puma Kids', 'slug' => Str::slug('Puma Kids')],
            ['name' => 'Under Armour Kids', 'slug' => Str::slug('Under Armour Kids')],
            ['name' => 'Little Me', 'slug' => Str::slug('Little Me')],
            ['name' => 'Janie and Jack', 'slug' => Str::slug('Janie and Jack')],
            ['name' => 'Ralph Lauren Kids', 'slug' => Str::slug('Ralph Lauren Kids')],
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
