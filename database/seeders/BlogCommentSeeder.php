<?php

namespace Database\Seeders;

use App\Models\BlogModel;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BlogCommentSeeder extends Seeder
{
    public function run()
    {
        $blog = BlogModel::first();
        $customer = User::where('is_admin', 0)->first();

        if (!$blog || !$customer) {
            return;
        }

        DB::table('blog_comment')->updateOrInsert(
            [
                'user_id' => $customer->id,
                'blog_id' => $blog->id,
            ],
            [
                'comment' => 'Helpful buying guide. I used this to compare a few products before ordering.',
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );
    }
}
