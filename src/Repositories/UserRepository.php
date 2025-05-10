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
            new \DateTimeImmutable($data['created_at'])
        ) : null;
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
            new \DateTimeImmutable($data['created_at'])
        ) : null;
    }

    public function save(User $user): void
    {
        $data = [
            'username' => $user->getUsername(),
            'login' => $user->getLogin(),
            'password' => $user->getPassword(),
            'created_at' => $user->getCreatedAt()->format('Y-m-d H:i:s'),
        ];

        if ($user->getId() === null) {
            $this->connection->insert('users', $data);
            $user = new User(
                $user->getUsername(),
                $user->getLogin(),
                $user->getPassword(),
                $this->connection->lastInsertId(),
                $user->isBanned(),
                $user->getCreatedAt()
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