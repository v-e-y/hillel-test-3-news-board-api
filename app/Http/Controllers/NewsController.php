<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreNewsRequest;
use App\Http\Resources\NewsResource;
use App\Models\News;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Validator;

class NewsController extends Controller
{    
    /**
     * Get all news
     * @return Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return NewsResource::collection(
            News::with('comments')->paginate(5)
        );
    }

    /**
     * Store the incoming News.
     * @param  App\Http\Requests\StoreNewsRequest  $request
     * @return NewsResource
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
     * @param  News $news
     * @return NewsResource
     */
    public function show(News $news): NewsResource
    {
        return new NewsResource($news);
    }
    
    /**
     * Update 1 News
     * @param  Request $request
     * @param  News $news
     * @return JsonResponse|NewsResource
     */
    public function update(Request $request, News $news)
    {   
        $validator = Validator::make(
            $request->all(), 
            [
                'title' => 'string|min:12|max:125',
                'link' => 'string|active_url|min:6|max:255|unique:news,link,' . $news->id,
                'upvotes' => 'numeric|min:0|gte:' . $news->upvotes
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
     * @param  News $news
     * @return JsonResponse
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
            'errors' => 'Some error(s) when trieng delete News'
        ]);
    }

    public function upvote(Request $request, News $news)
    {
        //dd($request, $news);

        $validator = Validator::make(
            $request->all(), 
            [
                'upvotes' => 'numeric|min:0|gte:' . $news->upvotes
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
}
