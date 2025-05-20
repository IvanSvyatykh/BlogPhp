<?php


namespace Pri301\Blog\Domain\Repository;


use Pri301\Blog\Domain\Entity\Like;

interface LikeRepositoryInterface
{

    public function addLike(Like $like): void;
    public function removeLike(int $postId, int $userId): void;
    public function hasLike(int $postId, int $userId): bool;
    public function countLikes(int $postId): int;

}