<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PartnerSeeder extends Seeder
{
    public function run()
    {
        foreach (['Nike', 'Samsung', 'Ikea', 'Maybelline'] as $partner) {
            DB::table('partner')->updateOrInsert(
                ['button_link' => '/brand/'.strtolower($partner)],
                [
                    'image_name' => null,
                    'is_delete' => 0,
                    'status' => 0,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }
}
