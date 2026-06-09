<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SubCategoryModel;
use App\Models\CategoryModel;
use App\Models\User;
use Illuminate\Support\Str;

class SubCategorySeeder extends Seeder
{
    public function run()
    {
        $admin = User::first();
        if (!$admin) {
            return;
        }

        $subCategories = [
            // Men's Clothing subcategories
            ['name' => 'T-Shirts', 'category_name' => 'Men\'s Clothing', 'slug' => Str::slug('T-Shirts')],
            ['name' => 'Shirts', 'category_name' => 'Men\'s Clothing', 'slug' => Str::slug('Shirts')],
            ['name' => 'Pants', 'category_name' => 'Men\'s Clothing', 'slug' => Str::slug('Pants')],
            ['name' => 'Jackets', 'category_name' => 'Men\'s Clothing', 'slug' => Str::slug('Jackets')],
            ['name' => 'Swimwear', 'category_name' => 'Men\'s Clothing', 'slug' => Str::slug('Swimwear')],
            ['name' => 'Underwear', 'category_name' => 'Men\'s Clothing', 'slug' => Str::slug('Underwear')],
            // Women's Clothing subcategories
            ['name' => 'Dresses', 'category_name' => 'Women\'s Clothing', 'slug' => Str::slug('Dresses')],
            ['name' => 'Tops', 'category_name' => 'Women\'s Clothing', 'slug' => Str::slug('Tops')],
            ['name' => 'Bottoms', 'category_name' => 'Women\'s Clothing', 'slug' => Str::slug('Bottoms')],
            ['name' => 'Skirts', 'category_name' => 'Women\'s Clothing', 'slug' => Str::slug('Skirts')],
            ['name' => 'Swimwear', 'category_name' => 'Women\'s Clothing', 'slug' => Str::slug('Women Swimwear')],
            ['name' => 'Lingerie', 'category_name' => 'Women\'s Clothing', 'slug' => Str::slug('Lingerie')],
            // Footwear subcategories
            ['name' => 'Casual Shoes', 'category_name' => 'Footwear', 'slug' => Str::slug('Casual Shoes')],
            ['name' => 'Running Shoes', 'category_name' => 'Footwear', 'slug' => Str::slug('Running Shoes')],
            ['name' => 'Sports Shoes', 'category_name' => 'Footwear', 'slug' => Str::slug('Sports Shoes')],
            ['name' => 'Sandals', 'category_name' => 'Footwear', 'slug' => Str::slug('Sandals')],
            ['name' => 'Boots', 'category_name' => 'Footwear', 'slug' => Str::slug('Boots')],
            ['name' => 'Formal Shoes', 'category_name' => 'Footwear', 'slug' => Str::slug('Formal Shoes')],
            // Accessories subcategories
            ['name' => 'Hats', 'category_name' => 'Accessories', 'slug' => Str::slug('Hats')],
            ['name' => 'Bags', 'category_name' => 'Accessories', 'slug' => Str::slug('Bags')],
            ['name' => 'Belts', 'category_name' => 'Accessories', 'slug' => Str::slug('Belts')],
            ['name' => 'Watches', 'category_name' => 'Accessories', 'slug' => Str::slug('Watches')],
            ['name' => 'Sunglasses', 'category_name' => 'Accessories', 'slug' => Str::slug('Sunglasses')],
            // Sports Wear subcategories
            ['name' => 'Gym Wear', 'category_name' => 'Sports Wear', 'slug' => Str::slug('Gym Wear')],
            ['name' => 'Yoga Wear', 'category_name' => 'Sports Wear', 'slug' => Str::slug('Yoga Wear')],
            ['name' => 'Running Gear', 'category_name' => 'Sports Wear', 'slug' => Str::slug('Running Gear')],
            ['name' => 'Team Sports', 'category_name' => 'Sports Wear', 'slug' => Str::slug('Team Sports')],
            // Kids Clothing subcategories
            ['name' => 'Boys', 'category_name' => 'Kids Clothing', 'slug' => Str::slug('Boys')],
            ['name' => 'Girls', 'category_name' => 'Kids Clothing', 'slug' => Str::slug('Girls')],
            ['name' => 'Baby', 'category_name' => 'Kids Clothing', 'slug' => Str::slug('Baby')],
            // Electronics subcategories
            ['name' => 'Smartphones', 'category_name' => 'Electronics', 'slug' => Str::slug('Smartphones')],
            ['name' => 'Laptops', 'category_name' => 'Electronics', 'slug' => Str::slug('Laptops')],
            ['name' => 'Audio', 'category_name' => 'Electronics', 'slug' => Str::slug('Audio')],
            ['name' => 'Wearables', 'category_name' => 'Electronics', 'slug' => Str::slug('Wearables')],
            // Home & Garden subcategories
            ['name' => 'Furniture', 'category_name' => 'Home & Garden', 'slug' => Str::slug('Furniture')],
            ['name' => 'Kitchen', 'category_name' => 'Home & Garden', 'slug' => Str::slug('Kitchen')],
            ['name' => 'Decor', 'category_name' => 'Home & Garden', 'slug' => Str::slug('Decor')],
            // Beauty & Health subcategories
            ['name' => 'Skincare', 'category_name' => 'Beauty & Health', 'slug' => Str::slug('Skincare')],
            ['name' => 'Makeup', 'category_name' => 'Beauty & Health', 'slug' => Str::slug('Makeup')],
            ['name' => 'Haircare', 'category_name' => 'Beauty & Health', 'slug' => Str::slug('Haircare')],
        ];

        foreach ($subCategories as $subCat) {
            $category = CategoryModel::where('name', $subCat['category_name'])->first();
            if ($category) {
                SubCategoryModel::firstOrCreate(
                    ['name' => $subCat['name'], 'category_id' => $category->id],
                    [
                        'slug' => $subCat['slug'],
                        'created_by' => $admin->id,
                        'is_delete' => 0,
                        'status' => 0,
                    ]
                );
            }
        }
    }
}
