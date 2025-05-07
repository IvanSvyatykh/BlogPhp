<?php

namespace app\entities;

class Comment
{
    private ?int $id;
    private string $content;
    private int $postId;
    private int $authorId;
    private \DateTimeImmutable $createdAt;
    private ?User $author = null;
    private ?Post $post = null;

    public function __construct(
        string $content,
        int $postId,
        int $authorId,
        ?int $id = null,
        ?\DateTimeImmutable $createdAt = null
    ) {
        $this->id = $id;
        $this->content = $content;
        $this->postId = $postId;
        $this->authorId = $authorId;
        $this->createdAt = $createdAt ?? new \DateTimeImmutable();
    }

    // Getters and setters
    public function getId(): ?int { return $this->id; }
    public function getContent(): string { return $this->content; }
    public function getPostId(): int { return $this->postId; }
    public function getAuthorId(): int { return $this->authorId; }
    public function getCreatedAt(): \DateTimeImmutable { return $this->createdAt; }
    public function getAuthor(): ?User { return $this->author; }
    public function setAuthor(User $author): void { $this->author = $author; }
    public function getPost(): ?Post { return $this->post; }
    public function setPost(Post $post): void { $this->post = $post; }
}