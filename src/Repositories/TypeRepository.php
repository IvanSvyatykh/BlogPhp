<?php
namespace Pri301\Blog\Repositories;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Pri301\Blog\Entity\Type;

class TypeRepository
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getAllTaypes(): array
    {
        return $this->entityManager
            ->createQueryBuilder()
            ->select('t')
            ->from(Type::class, 't')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
