<?php

namespace App\Repositories;

use App\Models\Comment;

interface CommentRepository
{
    public function save(array $data): Comment;
    public function findByColumn(string $column, mixed $value): Comment;
}
