<?php

namespace App\Services;

use App\Models\Community;
use App\Models\User;

interface CommunityService
{
    public function create(array $data): ?Community;
    public function update(array $data, Community $community): ?Community;
    public function JoinTheCommunity(User $user, int $communityId): void;
    public function leaveTheCommunity(User $user, int $communityId): void;
}
