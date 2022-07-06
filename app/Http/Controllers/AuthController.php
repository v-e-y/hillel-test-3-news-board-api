<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

final class AuthController extends Controller
{

    /**
     * Store the incoming News.
     * @param  App\Http\Requests\StoreUserRequest  $request
     * @return JsonResponse
     */
    public function register(StoreUserRequest $request): JsonResponse
    {
        if ($dataForRegistration = $request->validated()) {
            $dataForRegistration['password'] = Hash::make($dataForRegistration['password']);

            return response()->json(
                $this->createBearerToken(
                    User::create($dataForRegistration)
                )
            );
        }

        throw new \Exception("Something wrong when processing Register", 1);
    }

    /**
     * Store the incoming News.
     * @param  App\Http\Requests\LoginUserRequest  $request
     * @return JsonResponse
     */
    public function login(LoginUserRequest $request): JsonResponse
    {
        $dataForLogin = $request->validated();

        if (Auth::attempt($dataForLogin)) {
            return response()->json(
                $this->createBearerToken(
                    User::where('email', $dataForLogin['email'])->firstOrFail()
                )
            );
        }

        throw new \Exception("Something wrong when processing Login", 1);
    }

    //TODO "logout"

    /**
     * Create and return bearer token
     * @param  User $user
     * @return array
     */
    private function createBearerToken(User $user): array
    {
        return [
            'access_token' => $user->createToken('auth_token')->plainTextToken,
            'token_type' => 'Bearer'
        ];
    }
}
