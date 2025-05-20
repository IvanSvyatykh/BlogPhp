<?php

namespace Pri301\Blog\Infarastructure\Doctrine\Repositories;

use Doctrine\ORM\EntityManagerInterface;
use Pri301\Blog\Domain\Entity\Post;
use Pri301\Blog\Domain\Repository\PostRepositoryInterface;

class PostRepository implements PostRepositoryInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findPostById(int $id): ?Post
    {
        return $this->entityManager
            ->createQueryBuilder('p')
            ->select('p')
            ->from(Post::class, 'p')
            ->andWhere('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();

    }

    //it's for getting articles that make user
    public function findAllByUser(int $authorId , int $limit = 10, int $offset = 0): array
    {
        return $this->entityManager
            ->createQueryBuilder()
            ->select('p')
            ->from(Post::class, 'p')
            ->andWhere('p.author = :author')
            ->orderBy('p.createdAt', 'DESC')
            ->setParameter('author', $authorId)
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->getQuery()
            ->getArrayResult();
    }


    public function getArticlesByStatus(int $statusId , int $limit = 10, int $offset = 0 ): array
    {
        return $this->entityManager
            ->createQueryBuilder()
            ->select('p')
            ->from(Post::class, 'p')
            ->andWhere('p.status = :status')
            ->setParameter('status', $statusId)
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->getQuery()
            ->getArrayResult();
    }

    public function addPost(Post $post): void
    {
        $this->entityManager->persist($post);
        $this->entityManager->flush();
    }

    public function updatePostStatus(Post $post): void
    {

        $this->entityManager->createQueryBuilder()
            ->update(Post::class, 'p')
            ->set('p.status',':status')
            ->where('p.id = :id')
            ->setParameter('status', $post->getStatus())
            ->setParameter('id', $post->getId())
            ->getQuery()
            ->execute();
    }

    public function deletePost(int $id): int
    {
        return $this->entityManager
            ->createQueryBuilder()
            ->delete(Post::class, 'p')
            ->where('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->execute();
    }

    public function findPublishedByUserId(int $userId,int $publishStatusId): array
    {
        return $this -> entityManager
            ->createQueryBuilder()
            ->select('p')
            ->from(Post::class, 'p')
            ->where('p.author_id = :userId AND p.status = :status')
            ->setParameter('userId', $userId)
            ->setParameter('status', $publishStatusId)
            ->getQuery()
            ->getArrayResult();
    }

    public function findUnpublishedByUserId(int $userId,int $publishStatusId): array
    {
        return $this -> entityManager
            ->createQueryBuilder()
            ->select('p')
            ->from(Post::class, 'p')
            ->where('p.author_id = :userId AND p.status != :status')
            ->setParameter('userId', $userId)
            ->setParameter('status',$publishStatusId)
            ->getQuery()
            ->getArrayResult();
    }
}