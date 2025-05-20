<?php
namespace Pri301\Blog\Infarastructure\Doctrine\Repositories;

use Doctrine\ORM\EntityManagerInterface;
use Pri301\Blog\Domain\Entity\Type;

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
