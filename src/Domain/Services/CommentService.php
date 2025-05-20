<?php

namespace Pri301\Blog\Domain\Services;

use Doctrine\ORM\EntityManager;
use Pri301\Blog\Domain\Entity\Comment;
use Pri301\Blog\Domain\Entity\Post;
use Pri301\Blog\Infarastructure\Doctrine\Repositories\CommentRepository;

class CommentService implements CommentServiceInterface
{
    public function __construct(
        private CommentRepository $commentRepository,
        private EntityManager $entityManager
    ) {}

    public function addComment(array $data, int $postId, int $authorId): Comment
    {
        $comment = new Comment(
            $data['content'],
            $this->entityManager->getReference(Post::class, $postId),
            $this->entityManager->getReference(User::class, $authorId),
        );

        $this->commentRepository->addComment($comment);
        return $comment;
    }

    public function getCommentsForPost(int $postId): array
    {
        return $this->commentRepository->findByPost($postId);
    }
}