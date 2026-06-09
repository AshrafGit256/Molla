<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BlogModel;
use App\Models\BlogCategoryModel;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    public function run()
    {
        $blogs = [
            [
                'title' => '10 Fashion Trends That Will Dominate 2024',
                'slug' => Str::slug('10 Fashion Trends That Will Dominate 2024'),
                'category' => 'Fashion Trends',
                'description' => 'Discover the most influential fashion trends that are set to dominate 2024. From sustainable fashion to bold colors and oversized silhouettes, learn what\'s trending in the fashion world this year.',
                'short_description' => 'The top 10 fashion trends you need to know for 2024',
                'meta_title' => '10 Fashion Trends That Will Dominate 2024',
                'meta_description' => 'Explore the top fashion trends for 2024 and stay ahead of the curve',
                'meta_keywords' => 'fashion trends 2024, style, clothing',
            ],
            [
                'title' => 'How to Style Your Denim: A Complete Guide',
                'slug' => Str::slug('How to Style Your Denim: A Complete Guide'),
                'category' => 'Style Tips',
                'description' => 'Denim is a timeless wardrobe staple. Learn how to style denim jeans, jackets, and shirts in multiple ways. From casual looks to dressy outfits, master the art of denim styling.',
                'short_description' => 'Complete guide to styling denim in different ways',
                'meta_title' => 'How to Style Your Denim: A Complete Guide',
                'meta_description' => 'Learn professional denim styling tips and tricks',
                'meta_keywords' => 'denim styling, fashion tips, outfits',
            ],
            [
                'title' => 'Summer Shoe Collection 2024 Review',
                'slug' => Str::slug('Summer Shoe Collection 2024 Review'),
                'category' => 'Product Reviews',
                'description' => 'Read our comprehensive review of the best summer shoes for 2024. We break down comfort, style, and durability of our top picks.',
                'short_description' => 'Detailed review of summer shoe collection 2024',
                'meta_title' => 'Summer Shoe Collection 2024 Review',
                'meta_description' => 'Professional review of summer shoes and recommendations',
                'meta_keywords' => 'shoe review, summer collection, footwear',
            ],
            [
                'title' => 'How to Care for Your Cotton Clothes',
                'slug' => Str::slug('How to Care for Your Cotton Clothes'),
                'category' => 'Care and Maintenance',
                'description' => 'Cotton is a delicate fabric that requires proper care. Learn the best practices for washing, drying, and storing your cotton garments to keep them looking new for years.',
                'short_description' => 'Essential tips for caring for cotton clothing',
                'meta_title' => 'How to Care for Your Cotton Clothes',
                'meta_description' => 'Proper care guide for cotton clothing and fabrics',
                'meta_keywords' => 'cotton care, laundry, clothing maintenance',
            ],
            [
                'title' => 'Spring 2024 New Arrivals Showcase',
                'slug' => Str::slug('Spring 2024 New Arrivals Showcase'),
                'category' => 'Seasonal Collections',
                'description' => 'Check out our exciting spring 2024 collection featuring fresh colors, innovative designs, and timeless pieces. Discover new styles that are perfect for the upcoming season.',
                'short_description' => 'Exclusive preview of spring 2024 collection',
                'meta_title' => 'Spring 2024 New Arrivals Showcase',
                'meta_description' => 'New spring collection 2024 with fresh designs and colors',
                'meta_keywords' => 'spring collection, new arrivals, fashion',
            ],
        ];

        foreach ($blogs as $blog) {
            $category = BlogCategoryModel::where('name', $blog['category'])->first();
            if ($category) {
                BlogModel::firstOrCreate(
                    ['title' => $blog['title']],
                    [
                        'slug' => $blog['slug'],
                        'blog_category_id' => $category->id,
                        'description' => $blog['description'],
                        'short_description' => $blog['short_description'],
                        'meta_title' => $blog['meta_title'],
                        'meta_description' => $blog['meta_description'],
                        'meta_keywords' => $blog['meta_keywords'],
                        'status' => 0,
                        'is_delete' => 0,
                        'total_views' => rand(10, 500),
                    ]
                );
            }
        }
    }
}
