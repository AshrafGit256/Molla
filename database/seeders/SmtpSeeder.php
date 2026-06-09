<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SmtpSeeder extends Seeder
{
    public function run()
    {
        DB::table('smtp')->updateOrInsert(
            ['id' => 1],
            [
                'name' => 'Demo Mailer',
                'mail_mailer' => 'smtp',
                'mail_host' => 'smtp.example.com',
                'mail_port' => '587',
                'mail_username' => 'demo@example.com',
                'mail_password' => 'password',
                'mail_encryption' => 'tls',
                'mail_from_address' => 'noreply@example.com',
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );
    }
}
