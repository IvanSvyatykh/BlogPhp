<?php

namespace Pri301\Blog\Repositories;

use Doctrine\DBAL\Connection;
use Pri301\Blog\Enteties\Comment;

class CommentRepository
{
    public function __construct(
        private Connection $connection,
        private UserRepository $userRepository,
        private PostRepository $postRepository
    ) {}

    public function find(int $id): ?Comment
    {
        $data = $this->connection->fetchAssociative(
            'SELECT * FROM comments WHERE id = ?',
            [$id]
        );

        if (!$data) {
            return null;
        }

        $comment = new Comment(
            $data['content'],
            $data['post_id'],
            $data['author_id'],
            $data['id'],
            new \DateTimeImmutable($data['created_at'])
        );

        if ($author = $this->userRepository->find($data['author_id'])) {
            $comment->setAuthor($author);
        }

        if ($post = $this->postRepository->find($data['post_id'])) {
            $comment->setPost($post);
        }

        return $comment;
    }

    public function findByPost(int $postId): array
    {
        $data = $this->connection->fetchAllAssociative(
            'SELECT * FROM comments WHERE post_id = ? ORDER BY created_at DESC',
            [$postId]
        );

        $comments = [];
        foreach ($data as $commentData) {
            $comment = new Comment(
                $commentData['content'],
                $commentData['post_id'],
                $commentData['author_id'],
                $commentData['id'],
                new \DateTimeImmutable($commentData['created_at'])
            );

            if ($author = $this->userRepository->find($commentData['author_id'])) {
                $comment->setAuthor($author);
            }

            $comments[] = $comment;
        }

        return $comments;
    }

    public function save(Comment $comment): void
    {
        $data = [
            'content' => $comment->getContent(),
            'post_id' => $comment->getPostId(),
            'author_id' => $comment->getAuthorId(),
            'created_at' => $comment->getCreatedAt()->format('Y-m-d H:i:s'),
        ];

        if ($comment->getId() === null) {
            $this->connection->insert('comments', $data);
            $comment = new Comment(
                $comment->getContent(),
                $comment->getPostId(),
                $comment->getAuthorId(),
                $this->connection->lastInsertId(),
                $comment->getCreatedAt()
            );
        } else {
            $this->connection->update(
                'comments',
                $data,
                ['id' => $comment->getId()]
            );
        }
    }

    public function delete(int $id): void
    {
        $this->connection->delete('comments', ['id' => $id]);
    }
}