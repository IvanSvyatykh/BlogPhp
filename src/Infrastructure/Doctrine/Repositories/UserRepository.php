<?php

namespace Pri301\Blog\Infrastructure\Doctrine\Repositories;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Pri301\Blog\Domain\Entity\User;
use Pri301\Blog\Domain\Repository\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function addUser(User $user, bool $flush = true): void
    {
        $this->entityManager->persist($user);

        if ($flush) {
            $this->entityManager->flush();
        }
    }

    /**
     * Находит пользователя по логину
     * @throws NonUniqueResultException
     */
    public function findByLogin(string $login): ?User
    {
        return $this->entityManager
            ->createQueryBuilder()
            ->select('u')
            ->from(User::class, 'u')
            ->where('u.login = :login')
            ->setParameter('login', $login)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function setUserBannedStatus(int $userId , bool $isBanned): void
    {
        $this->entityManager
            ->createQueryBuilder()
            ->update(User::class, 'u')
            ->set('u.isBanned',':is_banned')
            ->where('u.id = :userId')
            ->setParameter('userId', $userId)
            ->setParameter('is_banned', $isBanned)
            ->getQuery()
            ->execute();
    }

    public function findById(int $id): ?User
    {
        return $this->entityManager->find(User::class, $id);
    }

    public function getAllUsers(): array
    {
        return $this -> entityManager
            ->createQueryBuilder()
            ->select('u')
            ->from(User::class, 'u')
            ->getQuery()
            ->getArrayResult();
    }

    public function getUsersIdBySubstrAtName(string $substr): array
    {
        return $this->entityManager
            ->createQueryBuilder()
            ->select('u.id')
            ->from(User::class, 'u')
            ->where('u.login LIKE :substr')
            ->setParameter('substr', '%' . $substr . '%')
            ->getQuery()
            ->getSingleColumnResult();
    }
}