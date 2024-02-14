<?php

namespace App\Services\Impl;

use App\Models\Comment;
use App\Models\Interfaces\Commentable;
use App\Repositories\CommentRepository;
use App\Repositories\UserRepository;
use App\Services\CommentService;
use Exception;
use Illuminate\Support\Facades\Log;

/**
 * Class CommentService
 *
 * Service class for handling comments.
 */
class CommentServiceImpl implements CommentService
{

    /**
     * CommentService constructor.
     *
     * @param CommentRepository $commentRepository The CommentRepository instance.
     * @param UserRepository $userRepository The UserRepository instance.
     */
    public function __construct(
        protected CommentRepository $commentRepository,
        protected UserRepository $userRepository,
    )
    {
    }

    /**
     * Creates a new comment.
     *
     * @param array $data The data for creating the comment.
     *
     * @return Comment|null The created Comment instance or null on failure.
     * @throws Exception If an error occurs during the creation process.
     */
    public function create(array $data): ?Comment
    {
        $data['user_id'] = auth()->user()->id;

        try {
            return $this->commentRepository->save($data);
        } catch (Exception $e) {
            Log::error('Failed to save the comment: ' . $e);
            return null;
        }
    }

    /**
     * Collects and prepares comments for a Commentable entity.
     *
     * @param Commentable $commentable The Commentable entity.
     *
     * @return array An array of prepared comments.
     */
    public function collectComments(Commentable $commentable): array
    {
        $comments = $commentable->parentComments()->with('user', 'children')->get();

        return array_map(function (Comment $comment) {
            return $this->getDataFromComment($comment);
        }, $comments->all());
    }

    /**
     * Prepares data from a Comment instance for display.
     *
     * @param Comment $comment The Comment instance.
     *
     * @return array An array containing prepared data from the Comment.
     */
    private function getDataFromComment(Comment $comment): array
    {
        $timeDifference = TimeServiceImpl::calculateCreatedAgoTime($comment->created_at);
        $commentChildren = $this->getChildren($comment);

        return [
            'id' => $comment->id,
            'avatar' => $comment->user->image,
            'username' => $comment->user->username,
            'post_time' => $timeDifference,
            'content' => $comment->content,
            'children' => $commentChildren ?: [],
        ];
    }

    /**
     * Recursively retrieves and prepares data from child comments.
     *
     * @param Comment $comment The parent Comment instance.
     *
     * @return array An array containing prepared data from child comments.
     */
    private function getChildren(Comment $comment): array
    {
        return $comment->children()->get()->map(function (Comment $childComment) {
            return $this->getDataFromComment($childComment);
        })->all();
    }
}
