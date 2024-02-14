<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommunityCreateRequest;
use App\Http\Requests\CommunityUpdateRequest;
use App\Http\Requests\ImageRequest;
use App\Http\Requests\LimitRequest;
use App\Http\Requests\PageRequest;
use App\Http\Resources\CommunitiesResource;
use App\Http\Resources\CommunityResource;
use App\Http\Resources\PostsResource;
use App\Models\Community;
use App\Repositories\CommunityRepository;
use App\Repositories\PostRepository;
use App\Services\CommunityService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CommunityController extends Controller
{

    public function __construct(
        protected CommunityRepository $communityRepository,
        protected CommunityService $communityService,
        protected PostRepository $postRepository,
    )
    {
    }

    public function handleGetPopularCommunities(LimitRequest $request): AnonymousResourceCollection
    {
        $data = $request->validated();
        $communities = $this->communityRepository->getPopularCommunities($data);

        return CommunitiesResource::collection($communities);
    }

    public function handleCreateCommunity(CommunityCreateRequest $request): JsonResponse
    {
        $data = $request->validated();
        $community = $this->communityService->create($data);

        return response()->json([
            'slug' => $community->slug,
        ], 201);
    }

    public function handleUpdateCommunity(CommunityUpdateRequest $request, string $slug): JsonResponse
    {
        $data = $request->validated();

        $community = $this->communityRepository->findByColumn('slug', $slug);
        $this->communityService->update($data, $community);

        return response()->json();
    }

    public function handleUploadAvatarToCommunity(ImageRequest $request, string $slug): JsonResponse
    {
        $data = $request->validated();

        $community = $this->communityRepository->findByColumn('slug', $slug);
        $this->communityService->update($data, $community);

        return response()->json();
    }

    public function handleJoinTheCommunity(int $id): JsonResponse
    {
        $this->communityRepository->findByColumn('id', $id);
        $user = auth()->user();

        $this->communityService->JoinTheCommunity($user, $id);
        return response()->json();
    }

    public function handleLeaveTheCommunity(int $id): JsonResponse
    {
        $this->communityRepository->findByColumn('id', $id);
        $user = auth()->user();

        $this->communityService->leaveTheCommunity($user, $id);
        return response()->json();
    }

    public function handleGetCommunityWithPosts(PageRequest $request, string $slug): JsonResponse
    {
        $data = $request->validated();

        $community = $this->communityRepository->findByColumn('slug', $slug);
        $posts = $this->postRepository->getPostsByColumn($data, 'community_id', $community->id);

        return response()->json([
            'community' => CommunityResource::make($community),
            'posts' => PostsResource::collection($posts),
            'last_page' => $posts->lastPage(),
        ]);
    }

    public function handleGetCommunity(string $slug): CommunityResource
    {
        $community = $this->communityRepository->findByColumn('slug', $slug);
        return CommunityResource::make($community);
    }
}
