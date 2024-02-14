<?php

namespace App\Services;

use App\Models\Post;

interface PostService
{
    public function create(array $data): ?Post;
}
