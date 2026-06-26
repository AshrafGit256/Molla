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
                'name' => env('MAIL_FROM_NAME', 'HenzNoval'),
                'mail_mailer' => env('MAIL_MAILER', 'smtp'),
                'mail_host' => env('MAIL_HOST', 'smtp.gmail.com'),
                'mail_port' => env('MAIL_PORT', '587'),
                'mail_username' => env('MAIL_USERNAME', 'utraxagency1@gmail.com'),
                'mail_password' => env('MAIL_PASSWORD'),
                'mail_encryption' => env('MAIL_ENCRYPTION', 'tls'),
                'mail_from_address' => env('MAIL_FROM_ADDRESS', 'utraxagency1@gmail.com'),
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );
    }
}
