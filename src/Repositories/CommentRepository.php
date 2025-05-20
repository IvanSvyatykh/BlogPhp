<?php

namespace Pri301\Blog\Repositories;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Pri301\Blog\Entity\Comment;

class CommentRepository
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function find(int $id): ?Comment
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

    public function save(Comment $comment): void
    {
       $this->entityManager->persist($comment);
       $this->entityManager->flush();
    }

    public function delete(int $id): void
    {
        $this->entityManager->remove($this->find($id));
        $this->entityManager->flush();
    }
}