<?php

namespace Pri301\Blog\Domain\Services;

use Doctrine\ORM\EntityManager;
use Pri301\Blog\Domain\Entity\Like;
use Pri301\Blog\Domain\Entity\Post;
use Pri301\Blog\Domain\Entity\User;
use Pri301\Blog\Domain\Repository\LikeRepositoryInterface;
use Pri301\Blog\Domain\Repository\UserRepositoryInterface;

class LikeService implements LikeServiceInterface
{
    public function __construct(
        private LikeRepositoryInterface $likeRepository,
        private UserRepositoryInterface $userRepository,
        private EntityManager $entityManager
    ) {
    }

    public function toggleLike(int $postId, string $userLogin): bool
    {
        $user = $this->userRepository->findByLogin($userLogin);
        $userId = $user->getId();

        if ($this->likeRepository->hasLike($postId, $userId)) {
            $this->likeRepository->removeLike($postId, $userId);
            return false;
        }

        $like = new Like(
            $this->entityManager->getReference(Post::class, $postId),
            $this->entityManager->getReference(User::class, $userId)
        );
        $this->likeRepository->addLike($like);
        return true;
    }

    public function countLikes(int $postId): int
    {
        return $this->likeRepository->countLikes($postId);
    }

    public function hasLike(int $postId, string $userLogin): bool
    {
        $user = $this->userRepository->findByLogin($userLogin);
        return $this->likeRepository->hasLike($postId, $user->getId());
    }
}