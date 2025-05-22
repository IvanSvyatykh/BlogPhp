<?php

namespace Pri301\Blog\Domain\Services;

use Pri301\Blog\Domain\Repository\UserRepositoryInterface;


class UserService
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function switchBanUser(int $userId): void
    {
       $this->userRepository->setUserBannedStatus($userId,false);
    }

    public function getUsersList(): array
    {
        return $this->userRepository->getAllUsers();
    }
}