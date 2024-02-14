<?php

namespace App\Repositories\Impl;

use App\Models\Theme;
use App\Repositories\ThemeRepository;
use Illuminate\Support\Collection;

class ThemeRepositoryImpl implements ThemeRepository
{
    public function getThemes(array $data): Collection
    {
        $limit = $data['limit'] ?? PHP_INT_MAX;
        $offset = $data['offset'] ?? 0;

        return Theme::query()
            ->when($offset > 0, function ($query) use ($offset, $limit) {
                return $query->offset($offset)->limit($limit);
            })
            ->when($limit > 0, function ($query) use ($offset, $limit) {
                return $query->limit($limit);
            })
            ->get();
    }
}
