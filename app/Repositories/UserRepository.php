<?php

namespace App\Repositories;

use App\Models\User;

interface UserRepository
{
    public function save(array $data): User;
    public function update(User $user, array $data): bool;
    public function findByColumn(string $column, mixed $value): User;
}
