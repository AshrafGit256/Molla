<?php

namespace Database\Seeders;

use App\Models\ProductModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProductImageSeeder extends Seeder
{
    public function run()
    {
        $images = [
            'Classic Cotton T-Shirt' => ['assets/images/demos/demo-23/new-men/product-1-1.jpg', 'assets/images/demos/demo-23/new-men/product-1-2.jpg'],
            'Striped Performance Tee' => ['assets/images/demos/demo-23/new-men/product-2-1.jpg', 'assets/images/demos/demo-23/new-men/product-2-2.jpg'],
            'Formal White Dress Shirt' => ['assets/images/demos/demo-23/new-men/product-3-1.jpg', 'assets/images/demos/demo-23/new-men/product-3-2.jpg'],
            'Casual Denim Shirt' => ['assets/images/demos/demo-23/new-men/product-4-1.jpg', 'assets/images/demos/demo-23/new-men/product-4-2.jpg'],
            'Black Slim Fit Jeans' => ['assets/images/demos/demo-22/products/product-1.jpg', 'assets/images/demos/demo-22/products/product-2.jpg'],
            'Elegant Summer Dress' => ['assets/images/demos/demo-23/new-women/product-1-1.jpg', 'assets/images/demos/demo-23/new-women/product-1-2.jpg'],
            'Black Formal Evening Dress' => ['assets/images/demos/demo-23/new-women/product-2-1.jpg', 'assets/images/demos/demo-23/new-women/product-2-2.jpg'],
            'Casual Blouse' => ['assets/images/demos/demo-23/new-women/product-3-1.jpg', 'assets/images/demos/demo-23/new-women/product-3-2.jpg'],
            'Pro Running Shoes' => ['assets/images/demos/demo-22/products/product-3.jpg', 'assets/images/demos/demo-22/products/product-4.jpg'],
            'Ultra-Light Sprint Trainers' => ['assets/images/demos/demo-22/products/product-5.jpg', 'assets/images/demos/demo-22/products/product-6.jpg'],
            'Classic White Sneakers' => ['assets/images/demos/demo-24/best-sellers/product-1-1.jpg', 'assets/images/demos/demo-24/best-sellers/product-1-2.jpg'],
            'Urban Street Sneakers' => ['assets/images/demos/demo-24/best-sellers/product-2-1.jpg', 'assets/images/demos/demo-24/best-sellers/product-2-2.jpg'],
            'Classic Baseball Cap' => ['assets/images/demos/demo-22/featured/product-1.jpg', 'assets/images/demos/demo-22/featured/product-2.jpg'],
            'Performance Gym T-Shirt' => ['assets/images/demos/demo-24/featured-products/product-1-1.jpg', 'assets/images/demos/demo-24/featured-products/product-1-2.jpg'],
            'Kids Adventure Hoodie' => ['assets/images/demos/demo-24/featured-products/product-2-1.jpg', 'assets/images/demos/demo-24/featured-products/product-2-2.jpg'],
            'Girls Floral Party Dress' => ['assets/images/demos/demo-24/featured-products/product-3-1.jpg', 'assets/images/demos/demo-24/featured-products/product-3-2.jpg'],
            'Samsung Galaxy A Series Phone' => ['assets/images/demos/demo-14/products/product-1.jpg', 'assets/images/demos/demo-14/products/product-2.jpg'],
            'Apple Air Lightweight Laptop' => ['assets/images/demos/demo-14/products/product-3.jpg', 'assets/images/demos/demo-14/products/product-4.jpg'],
            'Ikea Compact Coffee Table' => ['assets/images/demos/demo-10/products/product-1.jpg', 'assets/images/demos/demo-10/products/product-2.jpg'],
            'Modern Ceramic Dinner Set' => ['assets/images/demos/demo-10/products/product-3.jpg', 'assets/images/demos/demo-10/products/product-4.jpg'],
            'Maybelline Daily Makeup Kit' => ['assets/images/demos/demo-24/best-sellers/product-3-1.jpg', 'assets/images/demos/demo-24/best-sellers/product-3-2.jpg'],
            'Loreal Hydrating Skincare Set' => ['assets/images/demos/demo-24/best-sellers/product-4-1.jpg', 'assets/images/demos/demo-24/best-sellers/product-4-2.jpg'],
        ];

        File::ensureDirectoryExists(public_path('upload/product'));

        foreach (ProductModel::all() as $product) {
            $productImages = $images[$product->title] ?? [];

            foreach ($productImages as $index => $source) {
                $sourcePath = public_path($source);

                if (!File::exists($sourcePath)) {
                    continue;
                }

                $extension = pathinfo($sourcePath, PATHINFO_EXTENSION);
                $filename = 'seeded-product-'.$product->id.'-'.($index + 1).'.'.$extension;
                $destinationPath = public_path('upload/product/'.$filename);

                if (!File::exists($destinationPath)) {
                    File::copy($sourcePath, $destinationPath);
                }

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
        }
    }
}
