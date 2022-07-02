<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\News;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * @return void
     */
    public function run()
    {
        // Create 10 users and 1 News for each user.
        $users = User::factory(10)
            ->hasNews(1)
            ->create();

        // Create and connect Comment to User and News
        $users->each(function($user) {
            Comment::factory(2)
                ->state([
                    'author_name' => $user->name,
                    'news_id'  => News::all()->random()->id
                ])
                ->create();
        });
    }
}
