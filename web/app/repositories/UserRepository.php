<?php

namespace app\repositories;

use app\entities\User;
use Doctrine\DBAL\Connection;

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
            $data['email'],
            $data['password'],
            $data['id'],
            new \DateTimeImmutable($data['created_at'])
        ) : null;
    }

    public function findByEmail(string $email): ?User
    {
        $data = $this->connection->fetchAssociative(
            'SELECT * FROM users WHERE email = ?',
            [$email]
        );

        return $data ? new User(
            $data['username'],
            $data['email'],
            $data['password'],
            $data['id'],
            new \DateTimeImmutable($data['created_at'])
        ) : null;
    }

    public function save(User $user): void
    {
        $data = [
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
            'created_at' => $user->getCreatedAt()->format('Y-m-d H:i:s'),
        ];

        if ($user->getId() === null) {
            $this->connection->insert('users', $data);
            $user = new User(
                $user->getUsername(),
                $user->getEmail(),
                $user->getPassword(),
                $this->connection->lastInsertId(),
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