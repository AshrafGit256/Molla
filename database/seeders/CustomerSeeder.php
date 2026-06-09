<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        $customers = [
            [
                'name' => 'Grace Nanyonga',
                'last_name' => 'Nanyonga',
                'email' => 'grace@example.com',
                'phone' => '+256700111222',
                'city' => 'Kampala',
                'address_one' => 'Plot 12 Kampala Road',
            ],
            [
                'name' => 'Brian Okello',
                'last_name' => 'Okello',
                'email' => 'brian@example.com',
                'phone' => '+256700333444',
                'city' => 'Entebbe',
                'address_one' => 'Airport Road',
            ],
            [
                'name' => 'Amina Kato',
                'last_name' => 'Kato',
                'email' => 'amina@example.com',
                'phone' => '+256700555666',
                'city' => 'Jinja',
                'address_one' => 'Main Street',
            ],
        ];

        foreach ($customers as $customer) {
            DB::table('users')->updateOrInsert(
                ['email' => $customer['email']],
                [
                    'name' => $customer['name'],
                    'last_name' => $customer['last_name'],
                    'password' => Hash::make('password'),
                    'is_admin' => 0,
                    'status' => 0,
                    'is_delete' => 0,
                    'company_name' => null,
                    'country' => 'Uganda',
                    'address_one' => $customer['address_one'],
                    'address_two' => null,
                    'city' => $customer['city'],
                    'state' => 'Central',
                    'postcode' => '00000',
                    'phone' => $customer['phone'],
                    'email_verified_at' => now(),
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }
}
