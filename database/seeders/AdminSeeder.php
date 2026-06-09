<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Assuming your admin is in the User model

class AdminSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'arderguller@gmail.com'],
            [
                'name' => 'Arder Guller',
                'image_name' => 'h2.jpg',
                'password' => Hash::make('123456'), // You can hash the password here
                'is_admin' => 1, // Setting this user as admin
                'is_delete' => 0, // Default value
                'status' => 0, // Assuming 1 means active or enabled
            ]
        );

        User::where('is_admin', 1)
            ->where(function ($query) {
                $query->whereNull('image_name')
                    ->orWhere('image_name', '');
            })
            ->update(['image_name' => 'h2.jpg']);
    }
}
