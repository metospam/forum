<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\TrimStrings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::prefix('/v1')->group(function () {

    // topics
    Route::post('/topics', [TopicController::class, 'handleGetTopics']);

    //posts
    Route::post('/posts', [PostController::class, 'handleGetPosts']);
    Route::get('/posts/{slug}', [PostController::class, 'handleGetPost']);
    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('/posts/like/{id}', [PostController::class, 'handleLikePost']);
        Route::post('/posts/dislike/{id}', [PostController::class, 'handleDislikePost']);
        Route::post('/posts/create', [PostController::class, 'handleCreatePost']);
    });

    //users
    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('/users/avatar', [UserController::class, 'handleUploadAvatarToUser']);
        Route::patch('/users', [UserController::class, 'handleUpdateUser']);
    });

    Route::group(['middleware' => 'api'], function () {
        Route::post('/users/{username}', [UserController::class, 'handleGetUserWithPosts']);
    });

    //communities
    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('/communities/create', [CommunityController::class, 'handleCreateCommunity']);
        Route::patch('/communities/update/{slug}', [CommunityController::class, 'handleUpdateCommunity']);
        Route::post('/communities/avatar/{slug}', [CommunityController::class, 'handleUploadAvatarToCommunity']);
        Route::post('/communities/join/{id}', [CommunityController::class, 'handleJoinTheCommunity']);
        Route::post('/communities/leave/{id}', [CommunityController::class, 'handleLeaveTheCommunity']);
    });

    Route::group(['middleware' => 'api'], function () {
        Route::get('/communities/{slug}', [CommunityController::class, 'handleGetCommunity']);
    });

    Route::group(['middleware' => 'api'], function () {
        Route::post('/communities/popular', [CommunityController::class, 'handleGetPopularCommunities']);
        Route::post('/communities/{slug}', [CommunityController::class, 'handleGetCommunityWithPosts']);
    });

    //comments
    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('/comments/create', [CommentController::class, 'handleCreateComment']);
    });


    //auth
    Route::group(['prefix' => 'auth'], function () {
        Route::post('/register', [AuthController::class, 'handleRegisterUser']);

        Route::post('/login', [AuthController::class, 'handleAuthUser'])->middleware('api');
        Route::group(['middleware' => 'auth:api'], function () {
            Route::post('/refresh', [AuthController::class, 'handleRefreshToken']);
            Route::post('/data', [AuthController::class, 'handleGetUser']);
            Route::post('/logout', [AuthController::class, 'handleLogoutUser']);
        });
    });
});

