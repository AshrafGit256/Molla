<?php

namespace Database\Seeders;

use App\Models\ProductModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class ProductImageSeeder extends Seeder
{
    public function run()
    {
        File::ensureDirectoryExists(public_path('upload/product'));

        foreach (ProductModel::all() as $product) {
            $imageCount = rand(2, 4);

            for ($index = 0; $index < $imageCount; $index++) {
                $colorMap = [
                    'Sky Blue' => '87CEEB',
                    'Pink Rose' => 'FF69B4',
                    'Cloud White' => 'F5F5F5',
                    'Mint Green' => '98FB98',
                    'Sunshine Yellow' => 'FFD700',
                    'Lavender' => 'E6E6FA',
                    'Peach' => 'FFDAB9',
                    'Navy' => '000080',
                    'Red' => 'DC143C',
                    'Purple' => '9370DB',
                    'Coral' => 'FF7F50',
                    'Teal' => '008080',
                    'Mustard' => 'FFDB58',
                    'Sage' => '9ACD32',
                    'Blush' => 'DEADB0',
                    'Ocean' => '256D8C',
                    'Berry' => '8A2BE2',
                    'Ivory' => 'FFFFF0',
                    'Charcoal' => '36454F',
                    'Gold' => 'FFD700'
                ];

                $colorKey = array_rand($colorMap);
                $bgColor = $colorMap[$colorKey];

                $placeholderUrl = "https://placehold.co/600x600/{$bgColor}/FFFFFF/png?text=Product+{$product->id}+Image+" . ($index + 1);
                $extension = 'png';
                $filename = 'seeded-product-'.$product->id.'-'.($index + 1).'.'.$extension;
                $destinationPath = public_path('upload/product/'.$filename);

                try {
                    $imageContent = @file_get_contents($placeholderUrl);
                    if ($imageContent !== false) {
                        File::put($destinationPath, $imageContent);

                        DB::table('product_image')->updateOrInsert(
                            [
                                'product_id' => $product->id,
                                'order_by' => $index + 1,
                            ],
                            [
                                'image_name' => $filename,
                                'updated_at' => now(),
                                'created_at' => now(),
                            ]
                        );
                    }
                } catch (\Exception $e) {
                    continue;
                }
            }

            if (Schema::hasTable('product_image_color')) {
                $images = DB::table('product_image')
                    ->where('product_id', $product->id)
                    ->pluck('id')
                    ->values();

                $productColorIds = DB::table('product_color')
                    ->where('product_id', $product->id)
                    ->pluck('color_id')
                    ->values();

                foreach ($images as $imgIndex => $imageId) {
                    if ($productColorIds->count() > 0) {
                        $colorId = $productColorIds[$imgIndex % $productColorIds->count()];

                        DB::table('product_image_color')->updateOrInsert(
                            [
                                'product_image_id' => $imageId,
                                'color_id' => $colorId,
                            ],
                            [
                                'updated_at' => now(),
                                'created_at' => now(),
                            ]
                        );
                    }
                }
            }
        }
    }
}