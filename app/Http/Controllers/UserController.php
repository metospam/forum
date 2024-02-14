<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageRequest;
use App\Http\Requests\PageRequest;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\PostsResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\PostRepository;
use App\Repositories\UserRepository;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends Controller
{

    public function __construct(
        protected UserService    $userService,
        protected UserRepository $userRepository,
        protected PostRepository $postRepository,
    )
    {
    }


    public function handleUpdateUser(UserUpdateRequest $request): JsonResponse
    {
        $data = $request->validated();

        $userId = auth()->user()->id;
        $this->userService->update($data, $userId);

        return response()->json();
    }

    public function handleUploadAvatarToUser(ImageRequest $request): JsonResponse
    {
        $data = $request->validated();

        $userId = auth()->user()->id;
        $this->userService->update($data, $userId);

        return response()->json();
    }

    public function handleGetUserWithPosts(PageRequest $request, string $username): JsonResponse
    {
        $data = $request->validated();

        $user = $this->userRepository->findByColumn('username', $username);
        $posts = $this->postRepository->getPostsByColumn($data, 'user_id', $user->id);

        return response()->json([
            'user' => UserResource::make($user),
            'posts' => PostsResource::collection($posts),
            'last_page' => $posts->lastPage(),
        ]);
    }

}
