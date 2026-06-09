<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductSizeModel;
use App\Models\ProductModel;

class ProductSizeSeeder extends Seeder
{
    public function run()
    {
        $products = ProductModel::all();
        $sizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];

        foreach ($products as $product) {
            // Assign 3-5 random sizes to each product
            $randomSizes = array_slice($sizes, 0, rand(3, 5));
            
            foreach ($randomSizes as $size) {
                ProductSizeModel::firstOrCreate(
                    [
                        'product_id' => $product->id,
                        'name' => $size,
                    ],
                    [
                        'price' => $product->price + (rand(0, 20)),
                    ]
                );
            }
        }
    }
}
