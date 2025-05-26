<?php

namespace Pri301\Blog\Domain\Services;


use Pri301\Blog\Domain\Entity\Comment;

interface CommentServiceInterface{
    public function addComment(array $data, int $postId, int $authorId): Comment;
    public function getCommentsForPost(int $postId): array;
    public function getCommentsByUserLogin(string $userLogin): array;
}