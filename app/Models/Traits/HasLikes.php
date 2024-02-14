<?php

namespace App\Models\Traits;

use App\Models\Like;

trait HasLikes
{
    public function likesDiff(): int
    {
        $likes = Like::query()
            ->where('likeable_id', $this->id)
            ->where('likeable_type', $this->getMorphClass())
            ->where('is_like', true)->count();

        $dislikes = Like::query()
            ->where('likeable_id', $this->id)
            ->where('likeable_type', $this->getMorphClass())
            ->where('is_like', false)->count();

        return $likes - $dislikes;
    }
}
