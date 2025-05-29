<?php


namespace Pri301\Blog\Domain\Services;


interface LikeServiceInterface
{
    public function toggleLike(int $postId, string $userLogin): bool;

    public function countLikes(int $postId): int;

    public function hasLike(int $postId, string $userLogin): bool;
}