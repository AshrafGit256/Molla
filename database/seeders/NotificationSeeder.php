<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationSeeder extends Seeder
{
    public function run()
    {
        foreach (User::take(4)->get() as $user) {
            DB::table('notification')->updateOrInsert(
                [
                    'user_id' => $user->id,
                    'message' => 'Your demo account has seeded store activity.',
                ],
                [
                    'url' => '/user/dashboard',
                    'is_read' => 0,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }
}
