<?php

namespace Pri301\Blog\Infrastructure\Doctrine\Repositories;

use Doctrine\ORM\EntityManagerInterface;
use Pri301\Blog\Domain\Entity\Post;
use Pri301\Blog\Domain\Entity\Status;
use Pri301\Blog\Domain\Entity\User;
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

    public function findAll( int $limit = 10, int $offset = 0 ) : array
    {
        return $this->entityManager
            ->createQueryBuilder()
            ->select('p', 's', 'a', 't')
            ->from(Post::class, 'p')
            ->leftJoin('p.status', 's')
            ->leftJoin('p.author', 'a')
            ->leftJoin('p.type', 't')
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->getQuery()
            ->getArrayResult();
    }

    public function addPost(Post $post): int
    {
        $this->entityManager->persist($post);
        $this->entityManager->flush();
        return $post->getId();
    }

    public function updatePostStatusById(int $postId, int $statusId): void
    {
        $this->entityManager->createQueryBuilder()
            ->update(Post::class, 'p')
            ->set('p.status', ':statusId')
            ->where('p.id = :postId')
            ->setParameter('statusId', $statusId)
            ->setParameter('postId', $postId)
            ->getQuery()
            ->execute();
    }

    public function updatePostTypeAndStatusById(int $postId, int $typeId, int $statusId): void
    {
        $this->entityManager->createQueryBuilder()
            ->update(Post::class, 'p')
            ->set('p.type', ':typeId')
            ->set('p.status', ':statusId')
            ->where('p.id = :postId')
            ->setParameter('typeId', $typeId)
            ->setParameter('postId', $postId)
            ->setParameter('statusId', $statusId)
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
    /**
     * @return Post[]
     */
    public function findPublishedByUserId(int $userId,int $publishStatusId): array
    {
        return $this->entityManager
            ->createQueryBuilder()
            ->select('p')
            ->from(Post::class, 'p')
            ->where('IDENTITY(p.author) = :userId')
            ->andWhere('IDENTITY(p.status) = :statusId')
            ->setParameter('userId', $userId)
            ->setParameter('statusId', $publishStatusId)
            ->getQuery()
            ->getResult();
    }

    public function findUnpublishedByUserId(int $userId, int $publishStatusId): array
    {
        return $this->entityManager
            ->createQueryBuilder()
            ->select('p')
            ->from(Post::class, 'p')
            ->where('p.author = :userId AND p.status != :status')
            ->where('IDENTITY(p.author) = :userId')
            ->andWhere('IDENTITY(p.status) = :statusId')
            ->setParameter('userId', $userId)
            ->setParameter('statusId', $publishStatusId)
            ->getQuery()
            ->getResult();
    }

    public function getUnpublished(int $publishedStatusId): array
    {
        return $this->entityManager
            ->createQueryBuilder()
            ->select('p')
            ->from(Post::class, 'p')
            ->where('p.status = :statusId')
            ->setParameter('statusId', $publishedStatusId)
            ->getQuery()
            ->getResult();
    }

    public function getPostBySubstrAtContent(string $substr): array
    {
        $query_builder = $this -> entityManager ->createQueryBuilder();
        return $query_builder
            ->select('p')
            ->from(Post::class, 'p')
            ->where('p.content LIKE :substr and p.type is not null and p.status =1')
            ->setParameter('substr', '%' .$substr. '%')
            ->getQuery()
            ->getResult();
    }

    public function getPostsBySubstrAtTitle(string $substr): array
    {
        $query_builder = $this -> entityManager ->createQueryBuilder();
        return $query_builder
            ->select('p')
            ->from(Post::class, 'p')
            ->where('p.title LIKE :substr and p.type is not null and p.status =1')
            ->setParameter('substr', '%' .$substr. '%')
            ->getQuery()
            ->getResult();
    }

    public function getPostsWithTypes(array $typeIds): array
    {
        return $this->entityManager
            ->createQueryBuilder()
            ->select(' p')
            ->from(Post::class, 'p')
            ->where('p.type IN (:type) and p.type is not null and p.status =1')
            ->setParameter('type', $typeIds)
            ->getQuery()
            ->getResult();
    }
}