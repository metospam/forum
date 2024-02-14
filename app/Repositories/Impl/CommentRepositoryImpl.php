<?php

namespace App\Repositories\Impl;

use App\Models\Comment;
use App\Repositories\CommentRepository;

class CommentRepositoryImpl implements CommentRepository
{

    public function save(array $data): Comment
    {
        return Comment::query()->create($data);
    }

    public function findByColumn(string $column, mixed $value): Comment
    {
        return Comment::query()->where($column, $value)->firstOrFail();
    }
}
