<?php

namespace App\Services\Impl;

use App\Models\Interfaces\Likeable;
use App\Repositories\LikeRepository;
use App\Services\LikeService;

class LikeServiceImpl implements LikeService
{

    public function __construct(
        protected LikeRepository $likeRepository,
    )
    {
    }

    public function like(Likeable $likeable): void
    {
        $this->toggleLike($likeable, true);
    }

    public function dislike(Likeable $likeable): void
    {
        $this->toggleLike($likeable, false);
    }

    private function toggleLike(Likeable $likeable, bool $isLike): void
    {
        $userId = auth()->user()->id;

        $actualLike = $this->likeRepository->find($likeable, $userId, $isLike);
        $oppositeLike = $this->likeRepository->find($likeable, $userId, !$isLike);

        $data = $this->createData($likeable, $userId, $isLike);

        if ($this->isNewLike($actualLike, $oppositeLike)) {
            $this->likeRepository->save($data);
            return;
        }

        if ($oppositeLike) {
            $this->likeRepository->update($oppositeLike, $data);
            return;
        }

        $this->likeRepository->delete($actualLike);
    }

    private function createData(Likeable $likeable, int $userId, $isLike = true): array
    {
        return [
            'likeable_id' => $likeable->id,
            'likeable_type' => $likeable->getMorphClass(),
            'user_id' => $userId,
            'is_like' => $isLike,
        ];
    }

    private function isNewLike($actualLike, $oppositeLike): bool
    {
        return $actualLike === null && $oppositeLike === null;
    }
}
