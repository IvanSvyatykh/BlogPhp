<?php

namespace Pri301\Blog\Services;

use Pri301\Blog\Repositories\UserRepository;

class UserService
{
    public function __construct(
        private UserRepository $userRepository
    ) {}

    public function switchBanUser(int $userId): void
    {
        $user = $this->userRepository->find($userId);
        $user->switchBanned();
        $this->userRepository->save($user);
    }

    public function getUsersList(): array
    {
        return $this->userRepository->getAllUsers();
    }
}