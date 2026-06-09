<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PageTableSeeder extends Seeder
{
    public function run()
    {
        $pages = [
            ['name' => 'home', 'slug' => 'home', 'title' => 'Home'],
            ['name' => 'about', 'slug' => 'about', 'title' => 'About Us'],
            ['name' => 'faq', 'slug' => 'faq', 'title' => 'Frequently Asked Questions'],
            ['name' => 'contact', 'slug' => 'contact', 'title' => 'Contact Us'],
            ['name' => 'payment-method', 'slug' => 'payment-method', 'title' => 'Payment Methods'],
            ['name' => 'money-back-guarantee', 'slug' => 'money-back-guarantee', 'title' => 'Money Back Guarantee'],
            ['name' => 'return', 'slug' => 'return', 'title' => 'Returns'],
            ['name' => 'shipping', 'slug' => 'shipping', 'title' => 'Shipping'],
            ['name' => 'terms-condition', 'slug' => 'terms-condition', 'title' => 'Terms and Conditions'],
            ['name' => 'privacy-policy', 'slug' => 'privacy-policy', 'title' => 'Privacy Policy'],
        ];

        foreach ($pages as $page) {
            DB::table('page')->updateOrInsert(
                ['slug' => $page['slug']],
                [
                    'name' => $page['name'],
                    'title' => $page['title'],
                    'description' => 'Sample content for the '.$page['title'].' page. Replace this from the admin panel when ready.',
                    'meta_title' => $page['title'],
                    'meta_description' => 'Demo '.$page['title'].' page content.',
                    'meta_keywords' => $page['slug'],
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }
}
