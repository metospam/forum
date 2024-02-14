<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

interface UserService
{
    public function create(array $data): ?User;
    public function update(array $data, int $userId): User;
}
