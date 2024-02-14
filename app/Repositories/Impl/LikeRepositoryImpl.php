<?php

namespace App\Repositories\Impl;

use App\Models\Interfaces\Likeable;
use App\Models\Like;
use App\Repositories\LikeRepository;

class LikeRepositoryImpl implements LikeRepository
{
    public function save(array $data): void
    {
        Like::query()->create($data);
    }

    public function update(Like $like, array $data): void
    {
        $like->update($data);
    }

    public function find(Likeable $likeable, int $userId, bool $isLike): ?Like
    {
        return Like::query()
            ->where('likeable_type', $likeable::class)
            ->where('likeable_id', $likeable->id)
            ->where('is_like', $isLike)
            ->where('user_id', $userId)
            ->first();
    }

    public function delete(Like $like): void
    {
        $like->delete();
    }
}
