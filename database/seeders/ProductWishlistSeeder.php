<?php

namespace Database\Seeders;

use App\Models\ProductModel;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductWishlistSeeder extends Seeder
{
    public function run()
    {
        $customers = User::where('is_admin', 0)->take(3)->get();
        $products = ProductModel::take(3)->get();

        foreach ($customers as $index => $customer) {
            $product = $products->get($index);
            if (!$product) {
                continue;
            }

            DB::table('product_wishlist')->updateOrInsert(
                [
                    'user_id' => $customer->id,
                    'product_id' => $product->id,
                ],
                [
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }
}
