<?php
namespace Pri301\Blog\Domain\Services;

use Pri301\Blog\Domain\Entity\User;

interface UserServiceInterface{

    public function GetUserById(string $userLogin): ?User;
    public function switchBanUser(int $userId, bool $active): void;
    public function getUsersList(): array;
}