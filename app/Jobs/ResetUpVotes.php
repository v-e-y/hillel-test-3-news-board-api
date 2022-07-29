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

    /**
     * Execute the job.
     * @return void
     */
    public function handle()
    {
        News::where('upvotes', '>', 0)->each(function($news) {
            // Reset amount upvotes
            $news->update([
                'upvotes' => 0
            ]);
            // Remove upvotes
            $news->upVotes()->detach();
        });
    }
}
