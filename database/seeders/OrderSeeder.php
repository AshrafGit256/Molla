<?php

namespace Database\Seeders;

use App\Models\ProductModel;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    public function run()
    {
        $customers = User::where('is_admin', 0)->take(3)->get();
        $products = ProductModel::take(6)->get();

        if ($customers->isEmpty() || $products->isEmpty()) {
            return;
        }

        foreach ($customers as $index => $customer) {
            $lineProducts = $products->slice($index * 2, 2)->values();
            if ($lineProducts->isEmpty()) {
                $lineProducts = $products->take(2)->values();
            }

            $itemsTotal = $lineProducts->sum(function ($product) {
                return (float) $product->price;
            });
            $shippingAmount = $index === 0 ? 0 : 5.99;
            $discountAmount = $index === 1 ? 10 : 0;
            $totalAmount = max(0, $itemsTotal + $shippingAmount - $discountAmount);
            $orderNumber = 'ORD-'.now()->format('Ymd').'-'.str_pad((string) ($index + 1), 3, '0', STR_PAD_LEFT);

            DB::table('orders')->updateOrInsert(
                ['order_number' => $orderNumber],
                [
                    'transaction_id' => 'TXN-SEED-'.str_pad((string) ($index + 1), 3, '0', STR_PAD_LEFT),
                    'user_id' => $customer->id,
                    'first_name' => $customer->name,
                    'last_name' => $customer->last_name ?: 'Customer',
                    'company_name' => $customer->company_name,
                    'country' => $customer->country ?: 'Uganda',
                    'address_one' => $customer->address_one ?: 'Demo address',
                    'address_two' => $customer->address_two,
                    'city' => $customer->city ?: 'Kampala',
                    'state' => $customer->state,
                    'postcode' => $customer->postcode ?: '00000',
                    'phone' => $customer->phone ?: '+256700000000',
                    'email' => $customer->email,
                    'note' => 'Seeded demo order.',
                    'discount_code' => $discountAmount > 0 ? 'WELCOME10' : null,
                    'discount_amount' => number_format($discountAmount, 2, '.', ''),
                    'shipping_id' => $index + 1,
                    'shipping_amount' => number_format($shippingAmount, 2, '.', ''),
                    'total_amount' => number_format($totalAmount, 2, '.', ''),
                    'payment_method' => $index === 2 ? 'Cash on Delivery' : 'Card',
                    'status' => $index,
                    'is_delete' => 0,
                    'is_payment' => 1,
                    'payment_data' => json_encode(['source' => 'database seeder']),
                    'updated_at' => now(),
                    'created_at' => now()->subDays($index),
                ]
            );

            $orderId = DB::table('orders')->where('order_number', $orderNumber)->value('id');

            foreach ($lineProducts as $product) {
                DB::table('orders_item')->updateOrInsert(
                    [
                        'order_id' => $orderId,
                        'product_id' => $product->id,
                    ],
                    [
                        'quantity' => 1,
                        'price' => number_format((float) $product->price, 2, '.', ''),
                        'color_name' => $index === 0 ? 'Black' : 'Blue',
                        'size_name' => 'M',
                        'size_amount' => '0',
                        'total_price' => number_format((float) $product->price, 2, '.', ''),
                        'updated_at' => now(),
                        'created_at' => now()->subDays($index),
                    ]
                );
            }
        }
    }
}
