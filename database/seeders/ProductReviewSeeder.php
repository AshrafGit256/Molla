<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductReviewSeeder extends Seeder
{
    public function run()
    {
        $orderItems = DB::table('orders_item')
            ->join('orders', 'orders.id', '=', 'orders_item.order_id')
            ->where('orders.is_payment', 1)
            ->select('orders_item.product_id', 'orders_item.order_id', 'orders.user_id')
            ->take(6)
            ->get();

        $reviews = [
            ['rating' => 5, 'review' => 'Excellent quality and the order arrived exactly as expected.'],
            ['rating' => 4, 'review' => 'Good value for money. I would buy this again.'],
            ['rating' => 5, 'review' => 'The product feels premium and matches the description.'],
            ['rating' => 4, 'review' => 'Nice product, easy checkout, and fast delivery.'],
            ['rating' => 3, 'review' => 'Decent product for the price.'],
            ['rating' => 5, 'review' => 'Very happy with this purchase.'],
        ];

        foreach ($orderItems as $index => $item) {
            $review = $reviews[$index] ?? $reviews[0];

            DB::table('product_review')->updateOrInsert(
                [
                    'product_id' => $item->product_id,
                    'order_id' => $item->order_id,
                    'user_id' => $item->user_id,
                ],
                [
                    'rating' => $review['rating'],
                    'review' => $review['review'],
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }
}
