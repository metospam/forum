<?php

namespace App\Services;

use App\Models\Interfaces\Likeable;

interface LikeService
{
    public function like(Likeable $likeable): void;
    public function dislike(Likeable $likeable): void;
}
