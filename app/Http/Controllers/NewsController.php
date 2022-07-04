<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNewsRequest;
use App\Http\Resources\NewsResource;
use App\Models\News;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

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
     * Get one specific news
     * @param  string $news
     * @return NewsResource
     */
    public function show(string $news): NewsResource
    {
        return new NewsResource(
            News::where('link', $news)->firstOrFail()
        );
    }

    /**
     * Store the incoming News.
     * @param  App\Http\Requests\StoreNewsRequest  $request
     * @return Response
     */
    public function store(StoreNewsRequest $request)
    {
        
        News::create($request->validated());
        dd($request->validated());
    }
    

    // update

    // destroy
}
