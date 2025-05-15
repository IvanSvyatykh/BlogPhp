<?php

namespace Pri301\Blog\Services;

use Pri301\Blog\Repositories\CommentRepository;
use Pri301\Blog\Enteties\Comment;

class CommentService
{
    public function __construct(
        private CommentRepository $commentRepository
    ) {}

    public function addComment(array $data, int $postId, int $authorId): Comment
    {
        $comment = new Comment(
            $data['content'],
            $postId,
            $authorId
        );

        $this->commentRepository->save($comment);
        return $comment;
    }

    public function getCommentsForPost(int $postId): array
    {
        return $this->commentRepository->findByPost($postId);
    }
}