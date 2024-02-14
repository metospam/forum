<?php

namespace App\Repositories\Impl;

use App\Models\Community;
use App\Repositories\CommunityRepository;
use Illuminate\Database\Eloquent\Collection;

class CommunityRepositoryImpl implements CommunityRepository
{
    public function getPopularCommunities(array $data): Collection
    {
        $limit = $data['limit'] ?? PHP_INT_MAX;

        return Community::query()->withCount('users')
            ->orderByDesc('users_count')
            ->limit($limit)
            ->get();
    }

    public function save(array $data): Community
    {
        return Community::query()->create($data);
    }

    public function findByColumn(string $column, mixed $value): Community
    {
        return Community::query()->where($column, $value)->firstOrFail();
    }

    public function update(Community $community, array $data): bool
    {
        return $community->update($data);
    }
}
