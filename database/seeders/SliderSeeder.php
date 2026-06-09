<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SliderModel;

class SliderSeeder extends Seeder
{
    public function run()
    {
        $sliders = [
            [
                'title' => 'Summer Collection 2024',
                'button_name' => 'Shop Now',
                'button_link' => '/shop/summer-collection',
                'status' => 0,
            ],
            [
                'title' => 'New Arrivals',
                'button_name' => 'Explore',
                'button_link' => '/shop/new-arrivals',
                'status' => 0,
            ],
            [
                'title' => 'Special Discount - Up to 50% Off',
                'button_name' => 'Get Offer',
                'button_link' => '/shop?discount=true',
                'status' => 0,
            ],
            [
                'title' => 'Premium Brand Sale',
                'button_name' => 'View Sale',
                'button_link' => '/shop/brands-sale',
                'status' => 0,
            ],
            [
                'title' => 'Fashion Forward Styles',
                'button_name' => 'Discover',
                'button_link' => '/shop/trending',
                'status' => 0,
            ],
        ];

        foreach ($sliders as $slider) {
            SliderModel::firstOrCreate(
                ['title' => $slider['title']],
                [
                    'button_name' => $slider['button_name'],
                    'button_link' => $slider['button_link'],
                    'status' => $slider['status'],
                    'is_delete' => 0,
                ]
            );
        }
    }
}
