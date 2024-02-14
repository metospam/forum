<?php

namespace App\Repositories\Impl;

use App\Models\Post;
use App\Repositories\PostRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class PostRepositoryImpl implements PostRepository
{
    public function getPosts(array $data): LengthAwarePaginator
    {
        $page = $data['page'] ?? 1;
        $perPage = $data['per_page'] ?? 10;

        return Post::query()->paginate($perPage, ['*'], 'page', $page);
    }

    public function save(array $data): Post
    {
        return Post::query()->create($data);
    }

    public function findByColumn(string $column, mixed $value): Post
    {
        return Post::query()->where($column, $value)->firstOrFail();
    }

    public function getPostsByColumn(array $data, string $column, mixed $value): LengthAwarePaginator
    {
        $page = $data['page'] ?? 1;
        $perPage = $data['per_page'] ?? 10;

        return Post::query()->where($column, $value)
            ->paginate($perPage, ['*'], 'page', $page);
    }
}
