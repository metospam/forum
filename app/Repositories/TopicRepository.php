<?php

namespace App\Repositories;

use Illuminate\Support\Collection;

interface TopicRepository
{
    public function getTopics(array $data): Collection;
}
