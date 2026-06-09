<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ColorModel;
use App\Models\User;

class ColorSeeder extends Seeder
{
    public function run()
    {
        $admin = User::first();
        if (!$admin) {
            return;
        }

        $colors = [
            ['name' => 'Red', 'code' => '#FF0000'],
            ['name' => 'Blue', 'code' => '#0000FF'],
            ['name' => 'Green', 'code' => '#00FF00'],
            ['name' => 'Yellow', 'code' => '#FFFF00'],
            ['name' => 'Black', 'code' => '#000000'],
            ['name' => 'White', 'code' => '#FFFFFF'],
            ['name' => 'Gray', 'code' => '#808080'],
            ['name' => 'Purple', 'code' => '#800080'],
            ['name' => 'Orange', 'code' => '#FFA500'],
            ['name' => 'Pink', 'code' => '#FFC0CB'],
            ['name' => 'Brown', 'code' => '#A52A2A'],
            ['name' => 'Navy', 'code' => '#000080'],
        ];

        foreach ($colors as $color) {
            ColorModel::firstOrCreate(
                ['name' => $color['name']],
                [
                    'code' => $color['code'],
                    'created_by' => $admin->id,
                    'is_delete' => 0,
                    'status' => 0,
                ]
            );
        }
    }
}
