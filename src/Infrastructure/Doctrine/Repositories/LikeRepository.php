<?php

namespace Pri301\Blog\Infrastructure\Doctrine\Repositories;

use Doctrine\ORM\EntityManagerInterface;
use Pri301\Blog\Domain\Entity\Like;
use Pri301\Blog\Domain\Repository\LikeRepositoryInterface;

class LikeRepository implements LikeRepositoryInterface
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
            ->delete(Like::class, 'l')
            ->where('l.post = :post_id')
            ->andWhere('l.user = :user_id')
            ->setParameter('post_id', $postId)
            ->setParameter('user_id', $userId)
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
            ->select('count(l.id)')
            ->from(Like::class, 'l')
            ->where('l.post = :postId')
            ->setParameter('postId', $postId)
            ->getQuery()
            ->getSingleScalarResult();
    }
}