<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BottomSliderSeeder extends Seeder
{
    public function run()
    {
        $sliders = [
            ['sub_title' => 'Everyday value', 'title' => 'Complete your cart with accessories', 'button_name' => 'Browse Accessories', 'button_link' => '/accessories'],
            ['sub_title' => 'Home refresh', 'title' => 'Kitchen and living room essentials', 'button_name' => 'Shop Home', 'button_link' => '/home-garden'],
        ];

        foreach ($sliders as $slider) {
            DB::table('bottom_slider')->updateOrInsert(
                ['title' => $slider['title']],
                [
                    'sub_title' => $slider['sub_title'],
                    'image_name' => null,
                    'button_name' => $slider['button_name'],
                    'button_link' => $slider['button_link'],
                    'is_delete' => 0,
                    'status' => 0,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }
}
