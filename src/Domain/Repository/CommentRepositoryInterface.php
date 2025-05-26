<?php

namespace Pri301\Blog\Domain\Repository;


use Pri301\Blog\Domain\Entity\Comment;
use Pri301\Blog\Domain\Entity\User;

interface CommentRepositoryInterface
{
    public function findById(int $id): ?Comment;
    public function findByPost(int $postId): array;
    public function addComment(Comment $comment): void;
    public function deleteComment(int $id): int;
    public function findByAuthor(User $user): array;
}