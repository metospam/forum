<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentCreateRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Services\CommentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function __construct(
        protected CommentService $commentService,
    )
    {
    }

    public function handleCreateComment(CommentCreateRequest $request): JsonResponse
    {
        $data = $request->validated();
        $comment = $this->commentService->create($data);

        return CommentResource::make($comment)->response()->setStatusCode(201);
    }

}
