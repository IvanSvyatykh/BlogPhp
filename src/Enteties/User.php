<?php

namespace Pri301\Blog\Enteties;

class User
{
    private ?int $id;
    private string $username;
    private string $login;
    private string $password;
    private bool $isBanned;
    private \DateTimeImmutable $createdAt;
    private bool $isAdmin;
    private bool $isModerator;

    public function __construct(
        string $username,
        string $login,
        string $password,
        ?int $id = null,
        bool $isBanned = false,
        ?\DateTimeImmutable $createdAt = null,
        bool $isAdmin = false,
        bool $isModerator = false
    ) {
        $this->id = $id;
        $this->username = $username;
        $this->login = $login;
        $this->password = $password;
        $this->isBanned = $isBanned;
        $this->createdAt = $createdAt ?? new \DateTimeImmutable();
        $this->isAdmin = $isAdmin;
        $this->isModerator = $isModerator;
    }

    // Getters and setters
    public function getId(): ?int { return $this->id; }
    public function getUsername(): string { return $this->username; }
    public function getLogin(): string { return $this->login; }
    public function getPassword(): string { return $this->password; }
    public function isBanned(): bool { return $this->isBanned; }
    public function getCreatedAt(): \DateTimeImmutable { return $this->createdAt; }
    public function isAdmin(): bool { return $this->isAdmin; }
    public function isModerator(): bool { return $this->isModerator; }
    public function switchBanned(): void { $this->isBanned = !$this->isBanned; }
}