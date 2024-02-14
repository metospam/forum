<?php

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface PostRepository
{
    public function getPosts(array $data): LengthAwarePaginator;
    public function getPostsByColumn(array $data, string $column, mixed $value): LengthAwarePaginator;
    public function save(array $data): Post;
    public function findByColumn(string $column, mixed $value): Post;
}
