<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DiscountCodeModel;

class DiscountCodeSeeder extends Seeder
{
    public function run()
    {
        $discountCodes = [
            [
                'name' => 'SUMMER2024',
                'type' => 'percent',
                'percent_amount' => 15,
                'expire_date' => date('Y-m-d', strtotime('+30 days')),
                'status' => 0,
            ],
            [
                'name' => 'SAVE20',
                'type' => 'percent',
                'percent_amount' => 20,
                'expire_date' => date('Y-m-d', strtotime('+60 days')),
                'status' => 0,
            ],
            [
                'name' => 'WELCOME10',
                'type' => 'percent',
                'percent_amount' => 10,
                'expire_date' => date('Y-m-d', strtotime('+90 days')),
                'status' => 0,
            ],
            [
                'name' => 'FLASH25',
                'type' => 'percent',
                'percent_amount' => 25,
                'expire_date' => date('Y-m-d', strtotime('+7 days')),
                'status' => 0,
            ],
            [
                'name' => 'VIP30',
                'type' => 'percent',
                'percent_amount' => 30,
                'expire_date' => date('Y-m-d', strtotime('+45 days')),
                'status' => 0,
            ],
        ];

        foreach ($discountCodes as $code) {
            DiscountCodeModel::firstOrCreate(
                ['name' => $code['name']],
                [
                    'type' => $code['type'],
                    'percent_amount' => $code['percent_amount'],
                    'expire_date' => $code['expire_date'],
                    'status' => $code['status'],
                    'is_delete' => 0,
                ]
            );
        }
    }
}
