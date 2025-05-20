<?php
namespace Pri301\Blog\Infarastructure\Doctrine\Repositories;

use Doctrine\ORM\EntityManagerInterface;
use Pri301\Blog\Domain\Entity\Type;
use Pri301\Blog\Domain\Repository\TypeRepositoryInterface;

class TypeRepository implements TypeRepositoryInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getAllTypes(): array
    {
        return $this->entityManager
            ->createQueryBuilder()
            ->select('t')
            ->from(Type::class, 't')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
