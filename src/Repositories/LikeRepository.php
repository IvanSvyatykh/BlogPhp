<?php

namespace Pri301\Blog\Repositories;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Pri301\Blog\Entity\Like;

class LikeRepository
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function addLike(Like $like): void
    {
        $this->entityManager->persist($like);
        $this->entityManager->flush();
    }

    public function removeLike(int $postId, int $userId): void
    {
        $this->entityManager
            ->createQueryBuilder()
            ->delete(Like::class, 'like')
            ->where('like.post = :postId and like.user = :userId')
            ->setParameter('postId', $postId)
            ->setParameter('userId', $userId)
            ->getQuery()
            ->execute();
    }

    public function hasLike(int $postId, int $userId): bool
    {
        $result = $this->entityManager
            ->createQueryBuilder()
            ->select('COUNT(l.id)')
            ->from(Like::class, 'l')
            ->where('l.post = :postId AND l.user = :userId')
            ->setParameter('postId', $postId)
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getSingleScalarResult();

        return (bool) $result;
    }

    public function countLikes(int $postId): int
    {
        return $this ->entityManager
            ->createQueryBuilder()
            ->select('count(like.id)')
            ->from(Like::class, 'like')
            ->where('like.post = :postId')
            ->setParameter('postId', $postId)
            ->getQuery()
            ->getSingleScalarResult();
    }
}