<?php

namespace Pri301\Blog\Services;

use Pri301\Blog\Enteties\Like;
use Pri301\Blog\Repositories\LikeRepository;

class LikeService
{
    public function __construct(private LikeRepository $likeRepository) {}

    public function toggleLike(int $postId, int $userId): bool
    {
        if ($this->likeRepository->hasLike($postId, $userId)) {
            $this->likeRepository->removeLike($postId, $userId);
            return false;
        }

        $like = new Like($postId, $userId);
        $this->likeRepository->addLike($like);
        return true;
    }

    public function countLikes(int $postId): int
    {
        return $this->likeRepository->countLikes($postId);
    }

    public function hasLike(int $postId, int $userId): bool
    {
        return $this->likeRepository->hasLike($postId, $userId);
    }
}