<?php

namespace App\Services\Impl;

use App\Models\Post;
use App\Repositories\PostRepository;
use App\Services\ImageService;
use App\Services\PostService;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PostServiceImpl implements PostService
{

    public function __construct(
        protected ImageService $imageService,
        protected PostRepository $postRepository,
    )
    {
    }

    public function create(array $data): ?Post
    {
        $data = $this->prepareData($data);

        try {
            return $this->postRepository->save($data);
        } catch (Exception $e) {
            Log::error('Failed to save the comment: ' . $e);
            return null;
        }
    }

    private function prepareData(array $data): array
    {
        if(isset($data['image'])) {
            $data['image'] = $this->imageService->toBase64($data['image']);
        }

        $data['user_id'] = auth()->user()->id;
        $data['slug'] = Str::slug($data['title'], '_');

        return $data;
    }
}
