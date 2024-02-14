<?php

namespace App\Repositories;

use App\Models\Community;
use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface CommunityRepository
{
    public function getPopularCommunities(array $data): Collection;
    public function save(array $data): Community;
    public function update(Community $community, array $data): bool;
    public function findByColumn(string $column, mixed $value): Community;
}
