<?php


namespace Pri301\Blog\Domain\Repository;


use Pri301\Blog\Domain\Entity\User;

interface UserRepositoryInterface
{
    public function addUser(User $user, bool $flush = true): void;

    public function findByLogin(string $login): ?User;

    public function getAllUsers(): array;

    public function findById(int $id): ?User;

    public function setUserBannedStatus(int $userId, bool $isBanned): void;

    public function getUsersIdBySubstrAtName(string $substr): array;
}