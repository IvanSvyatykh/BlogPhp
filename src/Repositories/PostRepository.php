<?php

namespace Pri301\Blog\Repositories;

use DateTimeImmutable;
use Doctrine\DBAL\Connection;
use Exception;
use Pri301\Blog\Enteties\Post;

class PostRepository
{
    public function __construct(
        private Connection     $connection,
        private UserRepository $userRepository
    )
    {
    }

    public function find(int $id): ?Post
    {
        $data = $this->connection->fetchAssociative(
            'SELECT * FROM posts WHERE id = ?',
            [$id]
        );

        if (!$data) {
            return null;
        }

        $post = new Post(
            $data['title'],
            $data['content'],
            $data['author_id'],
            $data['id'],
            new DateTimeImmutable($data['created_at'])
        );

        if ($author = $this->userRepository->find($data['author_id'])) {
            $post->setAuthor($author);
        }

        return $post;
    }

    public function findAll(int $limit = 10, int $offset = 0): array
    {
        $data = $this->connection->fetchAllAssociative(
            'SELECT * FROM posts ORDER BY created_at DESC LIMIT ? OFFSET ?',
            [$limit, $offset],
            [\PDO::PARAM_INT, \PDO::PARAM_INT]
        );

        $posts = [];
        foreach ($data as $postData) {
            $post = new Post(
                $postData['title'],
                $postData['content'],
                $postData['author_id'],
                $postData['id'],
                new DateTimeImmutable($postData['created_at'])
            );

            if ($author = $this->userRepository->find($postData['author_id'])) {
                $post->setAuthor($author);
            }

            $posts[] = $post;
        }

        return $posts;
    }

    public function save(Post $post): void
    {
        $data = [
            'title' => $post->getTitle(),
            'content' => $post->getContent(),
            'author_id' => $post->getAuthorId(),
            'created_at' => $post->getCreatedAt()->format('Y-m-d H:i:s'),
            'is_published' => $post->isPublished()
        ];

        if ($post->getId() === null) {
            $this->connection->insert('posts', $data);
            $post = new Post(
                $post->getTitle(),
                $post->getContent(),
                $post->getAuthorId(),
                $this->connection->lastInsertId(),
                $post->getCreatedAt()
            );
        } else {
            $this->connection->update(
                'posts',
                $data,
                ['id' => $post->getId()]
            );
        }
    }

    public function delete(int $id): void
    {
        $this->connection->delete('posts', ['id' => $id]);
    }

    public function findPublishedByUserId(int $userId): array
    {
        return $this->hydratePosts($this->connection->fetchAllAssociative(
            'SELECT * FROM posts WHERE author_id = ? AND is_published = TRUE',
            [$userId]
        ));
    }

    public function findUnpublishedByUserId(int $userId): array
    {
        return $this->hydratePosts($this->connection->fetchAllAssociative(
            'SELECT * FROM posts WHERE author_id = ? AND is_published = FALSE',
            [$userId]
        ));
    }

    private function hydratePosts(array $rows): array
    {
        $posts = [];

        foreach ($rows as $row) {
            $post = new Post(
                $row['title'],
                $row['content'],
                $row['author_id'],
                $row['id'],
                new DateTimeImmutable($row['created_at'])
            );

            $post->setPublished((bool)$row['is_published']);

            if ($author = $this->userRepository->find($row['author_id'])) {
                $post->setAuthor($author);
            }

            $posts[] = $post;
        }

        return $posts;
    }
}