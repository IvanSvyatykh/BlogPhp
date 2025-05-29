<?php

namespace Pri301\Blog\Domain\Services;

use Doctrine\ORM\EntityManager;
use Pri301\Blog\Application\DTO\Response\CommentResponse;
use Pri301\Blog\Domain\Entity\Comment;
use Pri301\Blog\Domain\Entity\Post;
use Pri301\Blog\Domain\Entity\User;
use Pri301\Blog\Domain\Repository\CommentRepositoryInterface;

class CommentService implements CommentServiceInterface
{
    public function __construct(
        private CommentRepositoryInterface $commentRepository,
        private EntityManager $entityManager
    ) {
    }

    public function addComment(string $content, int $postId, int $authorId): Comment
    {
        $comment = new Comment(
            $content,
            $this->entityManager->getReference(Post::class, $postId),
            $this->entityManager->getReference(User::class, $authorId),
        );

        $this->commentRepository->addComment($comment);
        return $comment;
    }

    public function getCommentsForPost(int $postId): array
    {
        $comments = $this->commentRepository->findByPost($postId);
        $result = array();

        foreach ($comments as $comment) {
            $user = $comment->getAuthor();
            $result[] = new CommentResponse(
                comment_id: $comment->getId(),
                comment_text: $comment->getContent(),
                comment_author_login: $user->getLogin(),
                comment_author_name: $user->getName()
            );
        }

        return $result;
    }

    public function getCommentsByUser(User $user): array
    {
        $comments = $this->commentRepository->findByAuthorId($user->getId());

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