<?php

namespace Pri301\Blog\Domain\Services;


use Pri301\Blog\Domain\Entity\Comment;
use Pri301\Blog\Domain\Entity\User;

interface CommentServiceInterface
{
    public function addComment(string $content, int $postId, int $authorId): Comment;

    public function getCommentsForPost(int $postId): array;

    public function getCommentsByUser(User $user): array;
}