<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RiderSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'rider@example.com'],
            [
                'name' => 'Rider One',
                'last_name' => 'Delivery',
                'email' => 'rider@example.com',
                'password' => Hash::make('rider123'),
                'is_admin' => 0,
                'is_delivery' => 1,
                'is_delete' => 0,
                'status' => 0,
            ]
        );
    }
}
