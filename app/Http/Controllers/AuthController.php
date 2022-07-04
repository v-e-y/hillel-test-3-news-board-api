<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    /**
     * Store the incoming News.
     * @param  App\Http\Requests\StoreUserRequest  $request
     * @return JsonResponse
     */
    public function register(StoreUserRequest $request): JsonResponse
    {
        if ($request->validated()) {
            $user = User::create($request->validated());

            return response()->json([
                'access_token' => $user->createToken('auth_token')->plainTextToken,
                'token_type' => 'Bearer'
            ]);
        }

        throw new \Exception("Something wrong when processing Request", 1);
    }

    /**
     * Store the incoming News.
     * @param  App\Http\Requests\LoginUserRequest  $request
     * @return JsonResponse
     */
    public function login(LoginUserRequest $request): JsonResponse
    {
        // TODO
        dd($request->validated());
    }

    //TODO logout
}
