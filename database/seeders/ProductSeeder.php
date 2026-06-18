<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\SubCategoryModel;
use App\Models\BrandModel;
use App\Models\User;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $admin = User::first();
        if (!$admin) {
            return;
        }

        $categories = CategoryModel::all();
        $brands = BrandModel::all();
        $products = [];
        $skuCounter = 100001;

        $patterns = ['Dino', 'Floral', 'Striped', 'Animal', 'Polka Dot', 'Solid', 'Star', 'Heart', 'Rainbow', 'Unicorn'];
        $colors = ['Sky Blue', 'Pink Rose', 'Cloud White', 'Mint Green', 'Sunshine Yellow', 'Lavender', 'Peach', 'Navy', 'Red', 'Purple'];
        $materials = ['Cotton', 'Fleece', 'Denim', 'Flannel', 'Jersey'];
        $types = ['T-Shirt', 'Dress', 'Pants', 'Shorts', 'Romper', 'Jumpsuit', 'Top', 'Hoodie', 'Leggings', 'Sleepwear'];

foreach ($categories as $category) {
            $subCategories = SubCategoryModel::where('category_id', $category->id)->get();
            $productsPerCategory = 25;

            for ($i = 0; $i < $productsPerCategory; $i++) {
                $subCategory = $subCategories->random();
                $brand = $brands->random();
                
                $pattern = $patterns[array_rand($patterns)];
                $color = $colors[array_rand($colors)];
                $productNumber = $i + 1;
                $productName = $this->generateProductName($category->name, $subCategory->name, $pattern, $color) . ' #' . $productNumber;
                $price = rand(8, 49) + (rand(0, 99) / 100);
                $oldPrice = round($price * (115 + rand(0, 25)) / 100, 2);

                $products[] = [
                    'title' => $productName,
                    'description' => 'High-quality ' . strtolower($materials[array_rand($materials)]) . ' clothing for comfortable everyday wear',
                    'short_description' => 'Soft and comfortable kids clothing',
                    'price' => $price,
                    'old_price' => $oldPrice,
                    'category' => $category->name,
                    'sub_category' => $subCategory->name,
                    'brand' => $brand->name,
                    'sku' => $skuCounter++,
                    'additional_information' => 'Soft cotton material, machine washable, comfortable fit for active play',
                    'shipping_returns' => 'Free shipping. Easy returns within 30 days.',
                    'stock' => rand(15, 80),
                ];
}
        }

        foreach ($products as $prod) {
            $category = CategoryModel::where('name', $prod['category'])->first();
            $subCategory = SubCategoryModel::where('name', $prod['sub_category'])->first();
            $brand = BrandModel::where('name', $prod['brand'])->first();

            if ($category && $subCategory && $brand) {
                ProductModel::updateOrCreate(
                    ['title' => $prod['title']],
                    [
                        'description' => $prod['description'],
                        'slug' => Str::slug($prod['title']),
                        'short_description' => $prod['short_description'],
                        'price' => $prod['price'],
                        'old_price' => $prod['old_price'],
                        'category_id' => $category->id,
                        'sub_category_id' => $subCategory->id,
                        'brand_id' => $brand->id,
                        'sku' => $prod['sku'],
                        'additional_information' => $prod['additional_information'],
                        'shipping_returns' => $prod['shipping_returns'],
                        'created_by' => $admin->id,
                        'is_delete' => 0,
                        'status' => 0,
                        'in_stock' => $prod['stock'],
                        'out_of_stock' => 0,
                    ]
                );
            }
        }
    }

    private function generateProductName($category, $subCategory, $pattern, $color)
    {
        $ageGroup = '';
        if (strpos($category, 'Newborn') !== false) $ageGroup = 'Infant ';
        elseif (strpos($category, 'Baby') !== false) $ageGroup = 'Baby ';
        elseif (strpos($category, 'Toddler') !== false) $ageGroup = 'Toddler ';
        
        if (strpos($subCategory, 'Onesies') !== false) {
            return $ageGroup . 'Snap Sleeve Onesie - ' . $pattern . ' ' . $color;
        }
        if (strpos($subCategory, 'Sleepwear') !== false) {
            return $ageGroup . 'Cozy Pajama Set - ' . $pattern;
        }
        if (strpos($subCategory, 'Shoes') !== false) {
            return $ageGroup . 'First Walk Sneakers - ' . $color;
        }
        if (strpos($subCategory, 'Dress') !== false) {
            return $ageGroup . $pattern . ' Party Dress - ' . $color;
        }
        if (strpos($subCategory, 'Romper') !== false || strpos($subCategory, 'Jumpsuit') !== false) {
            return $ageGroup . $pattern . ' Romper - ' . $color;
        }
        
        return $ageGroup . $pattern . ' T-Shirt - ' . $color;
    }
}
