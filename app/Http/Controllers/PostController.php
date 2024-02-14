<?php

namespace App\Http\Controllers;

use App\Http\Requests\PageRequest;
use App\Http\Requests\PostCreateRequest;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostsResource;
use App\Repositories\PostRepository;
use App\Services\LikeService;
use App\Services\PostService;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{

    public function __construct(
        protected PostService $postService,
        protected PostRepository $postRepository,
        protected LikeService $likeService,
    )
    {
    }

    public function handleGetPosts(PageRequest $request): JsonResponse
    {
        $data = $request->validated();
        $posts = $this->postRepository->getPosts($data);

        return response()->json([
            'data' => PostsResource::collection($posts),
            'last_page' => $posts->lastPage()
        ]);
    }

    public function handleGetPost(String $slug): PostResource
    {
        $post = $this->postRepository->findByColumn('slug', $slug);
        return PostResource::make($post);
    }

    public function handleCreatePost(PostCreateRequest $request): JsonResponse
    {
        $data = $request->validated();
        $post = $this->postService->create($data);

        return response()->json([
           'slug' => $post->slug,
        ]);
    }

    public function handleLikePost(int $id): JsonResponse
    {
        $post = $this->postRepository->findByColumn('id', $id);
        $this->likeService->like($post);

        return response()->json([
            'likes_count' => $post->likesDiff(),
        ]);
    }

    public  function handleDislikePost(int $id): JsonResponse
    {
        $post = $this->postRepository->findByColumn('id', $id);
        $this->likeService->dislike($post);

        return response()->json([
            'likes_count' => $post->likesDiff(),
        ]);
    }

}
