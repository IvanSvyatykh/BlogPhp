<?php

namespace Pri301\Blog\Repositories;

use Doctrine\DBAL\Connection;
use Pri301\Blog\Enteties\User;

class UserRepository
{
    public function __construct(private Connection $connection) {}

    public function find(int $id): ?User
    {
        $data = $this->connection->fetchAssociative(
            'SELECT * FROM users WHERE id = ?',
            [$id]
        );

        return $data ? new User(
            $data['username'],
            $data['login'],
            $data['password'],
            $data['id'],
            $data['is_banned'],
            new \DateTimeImmutable($data['created_at']),
            $data['is_admin'],
        ) : null;
    }

    public function getAllUsers(): array
    {
        $data = $this->connection->fetchAssociative(
            'SELECT * FROM users'
        );

        return $this->recieveUsers($data);
    }

    private function recieveUsers(array $data): array
    {
        $users = array_map(function ($userData) {
            return new User(
                $userData['username'],
                $userData['login'],
                $userData['password'],
                $userData['id'],
                $userData['is_banned'],
                new \DateTimeImmutable($userData['created_at']),
                $userData['is_admin']
            );
        }, $data);

         return $users;
    }
    public function findByLogin(string $login): ?User
    {
        $data = $this->connection->fetchAssociative(
            'SELECT * FROM users WHERE login = ?',
            [$login]
        );

        return $data ? new User(
            $data['username'],
            $data['login'],
            $data['password'],
            $data['id'],
            $data['is_banned'],
            new \DateTimeImmutable($data['created_at']),
            $data['is_admin']
        ) : null;
    }

    public function save(User $user): void
    {
        $data = [
            'username' => $user->getUsername(),
            'login' => $user->getLogin(),
            'password' => $user->getPassword(),
            'created_at' => $user->getCreatedAt()->format('Y-m-d H:i:s'),
            'is_banned' => $user->isBanned(),
            'is_admin' => $user->isAdmin(),
        ];

        if ($user->getId() === null) {
            $this->connection->insert('users', $data);
            $user = new User(
                $user->getUsername(),
                $user->getLogin(),
                $user->getPassword(),
                $this->connection->lastInsertId(),
                $user->isBanned(),
                $user->getCreatedAt(),
                $user->isAdmin(),
            );
        } else {
            $this->connection->update(
                'users',
                $data,
                ['id' => $user->getId()]
            );
        }
    }
}