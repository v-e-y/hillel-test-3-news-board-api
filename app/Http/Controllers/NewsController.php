<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreNewsRequest;
use App\Http\Resources\NewsResource;
use App\Models\News;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Validator;

class NewsController extends Controller
{
    /**
     * Get all news
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return NewsResource::collection(
            News::paginate(5)
        );
    }

    /**
     * Store the incoming News.
     * @param  \App\Http\Requests\StoreNewsRequest  $request
     * @return \App\Http\Resources\NewsResource
     */
    public function store(StoreNewsRequest $request): NewsResource
    {
        $news = $request->user()->news()->create($request->validated());

        if ($news instanceof News) {
            return $this->show($news);
        }

        throw new \Exception("Some error(s) while saving News", 1);
    }

    /**
     * Return one specific News
     * @param  \App\Models\News $news
     * @return \App\Http\Resources\NewsResource
     */
    public function show(News $news): NewsResource
    {
        return NewsResource::make($news);
    }

    /**
     * Update 1 News
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\News $news
     * @return JsonResponse|NewsResource
     */
    public function update(Request $request, News $news): NewsResource
    {
        $validator = Validator::make(
            $request->all(),
            [
                'title' => 'string|min:12|max:125',
                'link' => 'string|active_url|min:6|max:255|unique:news,link,' . $news->id,
                'upvotes' => 'numeric|min:0'
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => 'error',
                    'errors' => $validator->errors()
                ],
                422
            );
        }

        $news->update(
            $request->all()
        );

        return $this->show($news);
    }

    /**
     * Delete News
     * @param  \App\Models\News $news
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(News $news): JsonResponse
    {
        if ($news->delete()) {
            return response()->json([
                'status' => 'info',
                'message' => 'News ' . $news->title . ' deleted'
            ]);
        }

        return response()->json([
            'status' => 'error',
            'errors' => 'Some error(s) when tried delete News'
        ]);
    }

    /**
     * Upvote news
     * @param  \App\Models\News $news
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\NewsResource
     */
    public function upvote(Request $request, News $news): NewsResource|JsonResponse
    {
        $user = $request->user();

        // Upvote if user didn't it earlier.
        if (self::isUpVoteUnique($user, $news)) {
            // Create record about upvote
            $user->newsUpVotes()->attach(
                $news->id
            );

            // Update amount of upvotes
            // Maybe should be Event...
            $news->update([
                'upvotes' => $news->upvotes + 1
            ]);

            return $this->show($news);
        }

        return response()->json([
            'status' => 'Alert',
            'errors' => 'You already upvote this news'
        ]);
    }
    
    /**
     * Check is User didn't upvote given News earlier.
     * @param  \App\Models\User $user
     * @param  \App\Models\News $news
     * @return bool
     */
    public static function isUpVoteUnique(User $user, News $news): bool
    {
        return $user->newsUpVotes()
            ->where('news.id', $news->id)
            ->get()
            ->isEmpty();
    }
}
