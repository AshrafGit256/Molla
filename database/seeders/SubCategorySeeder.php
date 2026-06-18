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
            // Newborn (0-12 months) subcategories
            ['name' => 'Onesies & Bodysuits', 'category_name' => 'Newborn (0-12 months)', 'slug' => Str::slug('Onesies & Bodysuits-newborn')],
            ['name' => 'Sleepwear', 'category_name' => 'Newborn (0-12 months)', 'slug' => Str::slug('Sleepwear-newborn')],
            ['name' => 'Newborn Shoes', 'category_name' => 'Newborn (0-12 months)', 'slug' => Str::slug('Newborn Shoes')],
            ['name' => 'Newborn Accessories', 'category_name' => 'Newborn (0-12 months)', 'slug' => Str::slug('Newborn Accessories')],
            // Baby (1-3 years) subcategories
            ['name' => 'T-Shirts & Tops', 'category_name' => 'Baby (1-3 years)', 'slug' => Str::slug('T-Shirts & Tops-baby')],
            ['name' => 'Pants & Leggings', 'category_name' => 'Baby (1-3 years)', 'slug' => Str::slug('Pants & Leggings-baby')],
            ['name' => 'Dresses & Rompers', 'category_name' => 'Baby (1-3 years)', 'slug' => Str::slug('Dresses & Rompers-baby')],
            ['name' => 'Baby Shoes', 'category_name' => 'Baby (1-3 years)', 'slug' => Str::slug('Baby Shoes')],
            ['name' => 'Baby Accessories', 'category_name' => 'Baby (1-3 years)', 'slug' => Str::slug('Baby Accessories')],
            // Toddler (3-5 years) subcategories
            ['name' => 'T-Shirts', 'category_name' => 'Toddler (3-5 years)', 'slug' => Str::slug('T-Shirts-toddler')],
            ['name' => 'Shorts', 'category_name' => 'Toddler (3-5 years)', 'slug' => Str::slug('Shorts-toddler')],
            ['name' => 'Dresses', 'category_name' => 'Toddler (3-5 years)', 'slug' => Str::slug('Dresses-toddler')],
            ['name' => 'Pants', 'category_name' => 'Toddler (3-5 years)', 'slug' => Str::slug('Pants-toddler')],
            ['name' => 'Toddler Shoes', 'category_name' => 'Toddler (3-5 years)', 'slug' => Str::slug('Toddler Shoes')],
            ['name' => 'Toddler Accessories', 'category_name' => 'Toddler (3-5 years)', 'slug' => Str::slug('Toddler Accessories')],
            // Kids (5-7 years) subcategories
            ['name' => 'Shirts', 'category_name' => 'Kids (5-7 years)', 'slug' => Str::slug('Shirts-kids')],
            ['name' => 'Pants', 'category_name' => 'Kids (5-7 years)', 'slug' => Str::slug('Pants-kids')],
            ['name' => 'Dresses & Skirts', 'category_name' => 'Kids (5-7 years)', 'slug' => Str::slug('Dresses & Skirts-kids')],
            ['name' => 'Kids Shoes', 'category_name' => 'Kids (5-7 years)', 'slug' => Str::slug('Kids Shoes')],
            ['name' => 'Kids Accessories', 'category_name' => 'Kids (5-7 years)', 'slug' => Str::slug('Kids Accessories')],
        ];

        foreach ($subCategories as $subCat) {
            $category = CategoryModel::where('name', $subCat['category_name'])->first();
            if ($category) {
                SubCategoryModel::updateOrCreate(
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
