<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BlogCategoryModel;
use Illuminate\Support\Str;

class BlogCategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Fashion Trends',
                'slug' => Str::slug('Fashion Trends'),
                'meta_title' => 'Latest Fashion Trends and Styles',
                'meta_description' => 'Discover the latest fashion trends and styling tips',
                'meta_keywords' => 'fashion trends, style, clothing',
            ],
            [
                'name' => 'Product Reviews',
                'slug' => Str::slug('Product Reviews'),
                'meta_title' => 'Honest Product Reviews',
                'meta_description' => 'Read detailed reviews of our products',
                'meta_keywords' => 'product reviews, ratings',
            ],
            [
                'name' => 'Style Tips',
                'slug' => Str::slug('Style Tips'),
                'meta_title' => 'Fashion and Style Tips',
                'meta_description' => 'Get expert styling and fashion tips',
                'meta_keywords' => 'style tips, fashion advice',
            ],
            [
                'name' => 'Seasonal Collections',
                'slug' => Str::slug('Seasonal Collections'),
                'meta_title' => 'New Seasonal Collections',
                'meta_description' => 'Explore our new seasonal collections',
                'meta_keywords' => 'seasonal, collections, new arrivals',
            ],
            [
                'name' => 'Care and Maintenance',
                'slug' => Str::slug('Care and Maintenance'),
                'meta_title' => 'How to Care for Your Clothes',
                'meta_description' => 'Learn how to properly care for your clothing',
                'meta_keywords' => 'care, maintenance, cleaning',
            ],
        ];

        foreach ($categories as $cat) {
            BlogCategoryModel::firstOrCreate(
                ['name' => $cat['name']],
                [
                    'slug' => $cat['slug'],
                    'meta_title' => $cat['meta_title'],
                    'meta_description' => $cat['meta_description'],
                    'meta_keywords' => $cat['meta_keywords'],
                    'status' => 0,
                    'is_delete' => 0,
                ]
            );
        }
    }
}
