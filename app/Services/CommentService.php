<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\Interfaces\Commentable;
use App\Models\Post;

interface CommentService
{
    public function create(array $data): ?Comment;
    public function collectComments(Commentable $commentable): array;
}
