<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', [AuthController::class, 'register'])->name('regiser');
Route::post('/login', [AuthController::class, 'login'])->name('login');

/**
 * API version 1 routes
 */
Route::middleware('auth:sanctum')
    ->prefix('v1')
    ->group(function () {
        
        Route::apiResource('news', NewsController::class);
        Route::apiResource('comment', CommentController::class);

        Route::patch('/upvotes/{news}', [NewsController::class, 'upvote']);
});