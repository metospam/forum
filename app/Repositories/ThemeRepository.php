<?php

namespace App\Repositories;

use Illuminate\Support\Collection;

interface ThemeRepository
{
    public function getThemes(array $data): Collection;
}
