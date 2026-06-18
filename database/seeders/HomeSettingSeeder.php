<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HomeSettingModel;

class HomeSettingSeeder extends Seeder
{
    public function run()
    {
        HomeSettingModel::updateOrCreate(['id' => 1], [
            'trendy_product_title' => 'New Arrivals',
            'shop_by_category_title' => 'Shop by Age Group',
            'recent_arrival_title' => 'Latest Kids Fashion',
            'blog_title' => 'Parenting Tips & Kids Style',
            'payment_delivery_title' => 'Easy Delivery',
            'payment_delivery_description' => 'Fast and reliable delivery for your little ones',
            'payment_delivery_image' => 'path/to/image.jpg',
            'refund_title' => 'Hassle-Free Returns',
            'refund_description' => 'Not happy with the fit? Easy returns for all kids items',
            'refund_image' => 'path/to/refund-image.jpg',
            'support_title' => '24/7 Support',
            'support_description' => 'We\'re here to help with sizing and product questions',
            'support_image' => 'path/to/support-image.jpg',
            'signup_title' => 'Adorable Styles for Little Ones',
            'signup_description' => 'Sign up for new arrivals, special offers, and parenting tips',
            'signup_image' => 'path/to/signup-image.jpg',
        ]);
    }
}
