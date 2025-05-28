<?php

namespace Pri301\Blog\Domain\Services;

use Pri301\Blog\Domain\Entity\User;
use Pri301\Blog\Domain\Repository\UserRepositoryInterface;


class UserService implements UserServiceInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function switchBanUser(int $userId, bool $active): void
    {
       $this->userRepository->setUserBannedStatus($userId, $active);
    }

    public function getUsersList(): array
    {
        return $this->userRepository->getAllUsers();
    }

    public function GetUserById(string $userLogin): ?User
    {
        return $this->userRepository->findByLogin($userLogin);
    }
}