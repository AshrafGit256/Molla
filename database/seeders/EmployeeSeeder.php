<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeSeeder extends Seeder
{
    public function run()
    {
        $employees = [
            ['name' => 'Sarah Admin', 'email' => 'sarah.admin@example.com', 'salary' => 1800.00, 'location' => 'Kampala'],
            ['name' => 'David Fulfilment', 'email' => 'david.fulfilment@example.com', 'salary' => 1450.00, 'location' => 'Entebbe'],
        ];

        foreach ($employees as $employee) {
            DB::table('employees')->updateOrInsert(
                ['email' => $employee['email']],
                [
                    'name' => $employee['name'],
                    'salary' => $employee['salary'],
                    'location' => $employee['location'],
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }
}
