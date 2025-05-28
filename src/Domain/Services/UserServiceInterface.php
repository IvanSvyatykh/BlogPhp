<?php
namespace Pri301\Blog\Domain\Services;

use Pri301\Blog\Domain\Entity\User;

interface UserServiceInterface{

    public function switchBanUser(int $userId, bool $active): void;
    public function getUserByLogin(string $userLogin): ?User;
    public function switchBanUser(int $userId): void;
    public function getUsersList(): array;
    public function getUserIdBySubstrAtName(string $substr): array;
    public function getUserById(int $userId): ?User;
}