<?php

namespace App\Providers;

use App\Repositories\CommentRepository;
use App\Repositories\CommunityRepository;
use App\Repositories\Impl\CommentRepositoryImpl;
use App\Repositories\Impl\CommunityRepositoryImpl;
use App\Repositories\Impl\LikeRepositoryImpl;
use App\Repositories\Impl\PostRepositoryImpl;
use App\Repositories\Impl\ThemeRepositoryImpl;
use App\Repositories\Impl\TopicRepositoryImpl;
use App\Repositories\Impl\UserRepositoryImpl;
use App\Repositories\LikeRepository;
use App\Repositories\PostRepository;
use App\Repositories\ThemeRepository;
use App\Repositories\TopicRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->bind(TopicRepository::class, TopicRepositoryImpl::class);
        $this->app->bind(ThemeRepository::class, ThemeRepositoryImpl::class);
        $this->app->bind(PostRepository::class, PostRepositoryImpl::class);
        $this->app->bind(UserRepository::class, UserRepositoryImpl::class);
        $this->app->bind(CommunityRepository::class, CommunityRepositoryImpl::class);
        $this->app->bind(CommentRepository::class, CommentRepositoryImpl::class);
        $this->app->bind(LikeRepository::class, LikeRepositoryImpl::class);
    }
}
