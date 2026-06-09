<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TopSliderSeeder extends Seeder
{
    public function run()
    {
        $sliders = [
            ['sub_title' => 'New season', 'title' => 'Fresh arrivals for every department', 'button_name' => 'Shop Now', 'button_link' => '/shop'],
            ['sub_title' => 'Limited offer', 'title' => 'Style, tech, and home picks ready to browse', 'button_name' => 'View Deals', 'button_link' => '/shop?discount=true'],
        ];

        foreach ($sliders as $slider) {
            DB::table('top_slider')->updateOrInsert(
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
