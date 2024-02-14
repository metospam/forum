<?php

namespace App\Repositories;

use App\Models\Interfaces\Likeable;
use App\Models\Like;
use Illuminate\Database\Eloquent\Model;

interface LikeRepository
{
    public function save(array $data): void;
    public function update(Like $like, array $data): void;
    public function find(Likeable $likeable, int $userId, bool $isLike): ?Like;
    public function delete(Like $like): void;
}
