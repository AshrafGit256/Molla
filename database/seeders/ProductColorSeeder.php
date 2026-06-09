<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductColorModel;
use App\Models\ProductModel;
use App\Models\ColorModel;

class ProductColorSeeder extends Seeder
{
    public function run()
    {
        $products = ProductModel::all();
        $colors = ColorModel::all();

        if ($colors->count() > 0) {
            foreach ($products as $product) {
                // Assign 2-4 random colors to each product
                $randomColors = $colors->random(rand(2, 4));
                
                foreach ($randomColors as $color) {
                    ProductColorModel::firstOrCreate(
                        [
                            'product_id' => $product->id,
                            'color_id' => $color->id,
                        ]
                    );
                }
            }
        }
    }
}
