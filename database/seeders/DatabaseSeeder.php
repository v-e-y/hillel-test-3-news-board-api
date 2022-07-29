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
        $users = User::factory(55)
            // Create news for each user
            ->hasNews(1)
            ->create();

        // Get all News.
        $news = News::all();

        // Create and connect Comment to User and News.
        $users->each(function($user) use ($news) {
            
            // Attach User upvotes to News.
            $user->newsUpVotes()
                ->attach([
                    $news->random()->id,
                    $news->random()->id
                ]);

            // Create Comments.
            Comment::factory(2)
                ->state([
                    'author_name' => $user->name,
                    'news_id'  => $news->random()->id
                ])
                ->create();
        });

        // Set amount of upvotes to each news
        $news->each(function($n) {
            $upvotes = $n->upVotes()->get()->unique();

            $n->update([
                'upvotes' => $upvotes->count()
            ]);
        });
    }
}
