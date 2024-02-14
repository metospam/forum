<?php

namespace App\Services\Impl;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\ImageService;
use App\Services\UserService;
use Exception;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UserServiceImpl implements UserService
{

    public function __construct(
        protected ImageService   $imageService,
        protected UserRepository $userRepository
    )
    {
    }

    public function create(array $data): ?User
    {
        $data = $this->prepareData($data);

        try {
            return $this->userRepository->save($data);
        } catch (Exception $e) {
            Log::error('Failed to save the comment: ' . $e);
            return null;
        }
    }

    public function update(array $data, int $userId): User
    {
        $user = $this->userRepository->findByColumn('id', $userId);

        $data = $this->prepareData($data);
        $this->userRepository->update($user, $data);

        return $user;
    }

    private function prepareData(array $data): array
    {
        if (isset($data['image'])) {
            $data['image'] = $this->imageService->toBase64($data['image']);
        }

        if(isset($data['username'])){
            $data['username'] = preg_replace('/\s+/', '', $data['username']);
        }

        return $data;
    }
}
