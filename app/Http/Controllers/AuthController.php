<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserGetRequest;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use App\Services\Impl\UserServiceImpl;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class AuthController extends Controller
{

    public function __construct(
        protected UserRepository $userRepository,
        protected UserService $userService,
    )
    {
    }

    public function handleAuthUser(UserGetRequest $request): JsonResponse
    {
        $data = $request->validated();
        $credentials = [
            'email' => $data['email'],
            'password' => $data['password'],
        ];

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function handleGetUser(): UserResource
    {
        return UserResource::make(auth()->user());
    }

    public function handleLogoutUser(): JsonResponse
    {
        auth()->logout();
        return response()->json();
    }

    public function handleRefreshToken(): JsonResponse
    {
        return $this->respondWithToken(auth()->refresh());
    }

    public function handleRegisterUser(UserCreateRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['api_token'] = Str::random(60);

        $this->userService->create($data);

        $credentials = [
            'email' => $data['email'],
            'password' => $data['password']
        ];

        return response()->json([
            'access_token' => auth()->attempt($credentials)
        ], 201);
    }

    private function respondWithToken(string $token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
