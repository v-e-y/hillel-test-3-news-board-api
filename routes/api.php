<?php

declare(strict_types=1);

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\NewsController;
use App\Http\Resources\CommentResource;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/**
 * Auth Routes
 */
Route::post('/register', [AuthController::class, 'register'])
    ->name('regiser');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login');

/**
 * API version 1 routes
 */
Route::middleware('auth:sanctum')
    ->prefix('v1')
    ->group(function () {
        
        // Route::apiResource('news', NewsController::class);
        Route::get('/news', [NewsController::class, 'index'])
            ->name('news.index');

        Route::post('/news', [NewsController::class, 'store'])
            ->name('news.store');

        Route::get('/news/{news}', [NewsController::class, 'show'])
            ->name('news.show');

        Route::patch('/news/{news}', [NewsController::class, 'update'])
            ->name('news.update');

        Route::delete('/news/{news}', [NewsController::class, 'destroy'])
            ->name('news.destroy');

        Route::get('/news/{news}/comments', function(News $news) {
            return CommentResource::collection(
                $news->comments()->get()
            );
        })->name('news.comments');

        Route::get('/upvotes/{news}', [NewsController::class, 'upvote']);

        // Route::apiResource('comment', CommentController::class);
        Route::post('/{news}/comment', [CommentController::class, 'store'])
            ->name('comment.store');

        Route::get('/comment/{comment}', [CommentController::class, 'show'])
            ->name('comment.show');

        Route::patch('/comment/{comment}', [CommentController::class, 'update'])
            ->name('comment.update');

        Route::delete('/comment/{comment}', [CommentController::class, 'destroy'])
            ->name('comment.destroy');
});
