<?php

namespace Pri301\Blog\Enteties;

class Like
{
    private int $postId;
    private int $userId;
    private \DateTimeImmutable $createdAt;

    public function __construct(
        int $postId,
        int $userId,
        ?\DateTimeImmutable $createdAt = null
    ) {
        $this->postId = $postId;
        $this->userId = $userId;
        $this->createdAt = $createdAt ?? new \DateTimeImmutable();
    }

    // Getters
    public function getPostId(): int { return $this->postId; }
    public function getUserId(): int { return $this->userId; }
    public function getCreatedAt(): \DateTimeImmutable { return $this->createdAt; }
}