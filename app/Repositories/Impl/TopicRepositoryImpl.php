<?php

namespace App\Repositories\Impl;

use App\Models\Topic;
use App\Repositories\TopicRepository;
use Illuminate\Support\Collection;

class TopicRepositoryImpl implements TopicRepository
{
    public function getTopics(array $data): Collection
    {
        $limit = $data['limit'] ?? PHP_INT_MAX;
        $offset = $data['offset'] ?? 0;

        return Topic::query()
            ->when($offset > 0, function ($query) use ($offset, $limit) {
                return $query->offset($offset)->limit($limit);
            })
            ->when($limit > 0, function ($query) use ($offset, $limit) {
                return $query->limit($limit);
            })
            ->get();
    }
}
