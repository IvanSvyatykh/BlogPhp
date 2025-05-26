<?php

namespace Pri301\Blog\Domain\Services;

use Doctrine\ORM\EntityManager;
use Pri301\Blog\Application\DTO\Response\CommentResponse;
use Pri301\Blog\Domain\Entity\Comment;
use Pri301\Blog\Domain\Entity\Post;
use Pri301\Blog\Domain\Repository\CommentRepositoryInterface;
use Pri301\Blog\Domain\Repository\UserRepositoryInterface;


class CommentService implements CommentServiceInterface
{
    public function __construct(
        private CommentRepositoryInterface $commentRepository,
        private UserRepositoryInterface $userRepository,
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
    public function getCommentsByUserLogin(string $userLogin): array
    {
        $user = $this->userRepository->findByLogin($userLogin);

        if (!$user) {
            throw new \RuntimeException('User not found');
        }

        $comments = $this->commentRepository->findByAuthor($user);

        return array_map(function (Comment $comment) use ($user) {
            return new CommentResponse(
                comment_id: $comment->getId(),
                comment_text: $comment->getContent(),
                comment_author_login: $user->getLogin(),
                comment_author_name: $user->getName()
            );
        }, $comments);
    }
}