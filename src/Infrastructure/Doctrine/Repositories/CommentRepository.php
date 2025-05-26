<?php

namespace Pri301\Blog\Infrastructure\Doctrine\Repositories;

use Doctrine\ORM\EntityManagerInterface;
use Pri301\Blog\Domain\Entity\Comment;
use Pri301\Blog\Domain\Entity\Post;
use Pri301\Blog\Domain\Entity\User;
use Pri301\Blog\Domain\Repository\CommentRepositoryInterface;

class CommentRepository implements CommentRepositoryInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findById(int $id): ?Comment
    {
        return $this->entityManager->find(Comment::class, $id);
    }

    public function findByPost(int $postId): array
    {
       return   $this->entityManager
           ->createQueryBuilder()
           ->select('comment')
           ->from(Comment::class, 'comment')
           ->where('comment.post_id = :postId')
           ->setParameter('postId', $postId)
           ->getQuery()
           ->getArrayResult();
    }

    public function addComment(Comment $comment): void
    {
       $this->entityManager->persist($comment);
       $this->entityManager->flush();
    }

    public function deleteComment(int $id): int
    {
        return $this->entityManager
            ->createQueryBuilder()
            ->delete(Comment::class, 'c')
            ->where('c.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->execute();
    }

    public function findByAuthorId(int $userId): array
    {
        return $this->entityManager
            ->createQueryBuilder()
            ->select('c')
            ->from(Comment::class, 'c')
            ->join('c.author', 'a')                      // join с сущностью User
            ->where('a.id = :authorId')                  // фильтрация по id пользователя
            ->orderBy('c.createdAt', 'DESC')
            ->setParameter('authorId', $userId)
            ->getQuery()
            ->getResult();
    }
}