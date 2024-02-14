<?php

namespace App\Providers;

use App\Services\CommentService;
use App\Services\CommunityService;
use App\Services\ImageService;
use App\Services\Impl\CommentServiceImpl;
use App\Services\Impl\CommunityServiceImpl;
use App\Services\Impl\ImageServiceImpl;
use App\Services\Impl\LikeServiceImpl;
use App\Services\Impl\PostServiceImpl;
use App\Services\Impl\UserServiceImpl;
use App\Services\LikeService;
use App\Services\PostService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->bind(ImageService::class, ImageServiceImpl::class);
        $this->app->bind(PostService::class, PostServiceImpl::class);
        $this->app->bind(UserService::class, UserServiceImpl::class);
        $this->app->bind(CommunityService::class, CommunityServiceImpl::class);
        $this->app->bind(CommentService::class, CommentServiceImpl::class);
        $this->app->bind(LikeService::class, LikeServiceImpl::class);
    }
}
