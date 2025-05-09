<?php

namespace app\repositories;

use Doctrine\DBAL\Connection;
use Pri301\Blog\Enteties\Like;

class LikeRepository
{
    public function __construct(private Connection $connection) {}

    public function addLike(Like $like): void
    {
        $this->connection->insert('likes', [
            'post_id' => $like->getPostId(),
            'user_id' => $like->getUserId(),
            'created_at' => $like->getCreatedAt()->format('Y-m-d H:i:s'),
        ]);
    }

    public function removeLike(int $postId, int $userId): void
    {
        $this->connection->delete('likes', [
            'post_id' => $postId,
            'user_id' => $userId,
        ]);
    }

    public function hasLike(int $postId, int $userId): bool
    {
        return (bool) $this->connection->fetchOne(
            'SELECT 1 FROM likes WHERE post_id = ? AND user_id = ?',
            [$postId, $userId]
        );
    }

    public function countLikes(int $postId): int
    {
        return $this->connection->fetchOne(
            'SELECT COUNT(*) FROM likes WHERE post_id = ?',
            [$postId]
        );
    }
}