<?php

namespace Pri301\Blog\Enteties;

use Pri301\Blog\Enum\PostStatus;

class Post
{
    private ?int $id;
    private string $title;
    private string $content;
    private int $authorId;
    private \DateTimeImmutable $createdAt;
    private ?User $author = null;
    private bool $isPublished = false;
    private PostStatus $status;

    public function __construct(
        string $title,
        string $content,
        int $authorId,
        ?int $id = null,
        ?\DateTimeImmutable $createdAt = null,
        PostStatus $status = PostStatus::Pending
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->authorId = $authorId;
        $this->createdAt = $createdAt ?? new \DateTimeImmutable();
        $this->status = $status;
    }

    // Getters and setters
    public function getId(): ?int { return $this->id; }
    public function getTitle(): string { return $this->title; }
    public function getContent(): string { return $this->content; }
    public function getAuthorId(): int { return $this->authorId; }
    public function getCreatedAt(): \DateTimeImmutable { return $this->createdAt; }
    public function getAuthor(): ?User { return $this->author; }
    public function setAuthor(User $author): void { $this->author = $author; }
    public function isPublished(): bool { return $this->isPublished; }
    public function setPublished(bool $value): void { $this->isPublished = $value; }

}