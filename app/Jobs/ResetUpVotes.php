<?php

declare(strict_types=1);

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\News;

class ResetUpVotes implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    //public News $news;

    /**
     * Execute the job.
     * @return void
     */
    public function handle()
    {
        News::where('upvotes', '>', 0)->update(['upvotes' => 0]);

        /*
        if ($news = News::where('upvotes', '>', 0)->get()) {
            $news->each(function ($n) {
                $n->update(['upvotes'=> 0]);
            });
        }
        */
    }
}
