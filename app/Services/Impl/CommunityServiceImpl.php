<?php

namespace App\Services\Impl;

use App\Models\Community;
use App\Models\User;
use App\Repositories\CommunityRepository;
use App\Services\CommunityService;
use App\Services\ImageService;
use Exception;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Str;

class CommunityServiceImpl implements CommunityService
{

    function __construct(
        protected CommunityRepository $communityRepository,
        protected ImageService $imageService,
    )
    {
    }

    /**
     * @throws Exception
     */
    public function create(array $data): ?Community
    {
        $data = $this->prepareData($data);

        try {
            $community = $this->communityRepository->save($data);
            $this->setCommunityAdministrator($community);

            return $community;
        } catch (Exception $e) {
            Log::error('Failed to save the community: ' . $e);
            return null;
        }
    }

    public function JoinTheCommunity(User $user, int $communityId): void
    {
        $user->communities()->attach($communityId);
    }

    public function leaveTheCommunity(User $user, int $communityId): void
    {
        $user->communities()->detach($communityId);
    }

    public function update(array $data, $community): ?Community
    {
        if (Gate::denies('can-update-community', $community)) {
            abort(403, 'Unauthorized.');
        }

        $data = $this->prepareData($data);
        $this->communityRepository->update($community, $data);

        return $community;
    }

    private function prepareData(array $data): array
    {
        $data['user_id'] = auth()->user()->id;

        if(isset($data['name'])) {
            $data['name'] = preg_replace('/\s+/', '', $data['name']);
            $data['slug'] = strtolower($data['name']);
        }

        if(isset($data['image'])){
            $data['image'] = $this->imageService->toBase64($data['image']);
        }

        return $data;
    }

    private function setCommunityAdministrator(Community $community): void
    {
        $userId = auth()->user()->id;
        $community->users()->attach($userId, ['role' => 'admin']);
    }
}

