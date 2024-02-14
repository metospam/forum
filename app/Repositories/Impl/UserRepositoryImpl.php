<?php

namespace App\Repositories\Impl;

use App\Models\User;
use App\Repositories\UserRepository;

class UserRepositoryImpl implements UserRepository
{
    public function save(array $data): User
    {
        return User::query()->create($data);
    }

    public function findByColumn(string $column, mixed $value): User
    {
        return User::query()->where($column, $value)->firstOrFail();
    }

    public function update(User $user, array $data): bool
    {
        return $user->update($data);
    }
}
