<?php

namespace Pri301\Blog\Domain\Services;

use Pri301\Blog\Domain\Entity\Comment;
use Pri301\Blog\Infarastructure\Doctrine\Repositories\CommentRepository;

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