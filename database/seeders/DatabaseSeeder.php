<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Call your seeder classes here
        $this->call(AdminSeeder::class);
        $this->call(SystemSettingSeeder::class);
        
    }
}
