<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ShippingChargeModel;

class ShippingChargeSeeder extends Seeder
{
    public function run()
    {
        $shippingCharges = [
            [
                'name' => 'Standard Shipping',
                'price' => '5.99',
                'status' => 0,
            ],
            [
                'name' => 'Express Shipping',
                'price' => '12.99',
                'status' => 0,
            ],
            [
                'name' => 'Overnight Shipping',
                'price' => '24.99',
                'status' => 0,
            ],
            [
                'name' => 'Free Shipping',
                'price' => '0.00',
                'status' => 0,
            ],
            [
                'name' => 'International Shipping',
                'price' => '45.00',
                'status' => 0,
            ],
        ];

        foreach ($shippingCharges as $charge) {
            ShippingChargeModel::firstOrCreate(
                ['name' => $charge['name']],
                [
                    'price' => $charge['price'],
                    'status' => $charge['status'],
                    'is_delete' => 0,
                ]
            );
        }
    }
}
