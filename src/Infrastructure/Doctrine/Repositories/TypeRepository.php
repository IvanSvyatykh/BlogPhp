<?php
namespace Pri301\Blog\Infrastructure\Doctrine\Repositories;

use Doctrine\ORM\AbstractQuery;
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
            ->getArrayResult();
    }

    public function findCategoryByName(string $name): ?Type
    {
        return $this->entityManager
            ->createQueryBuilder()
            ->select('t')
            ->from(Type::class, 't')
            ->andWhere('t.type = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getTypeById(int $id): string
    {
        $result = $this->entityManager->createQueryBuilder()
            ->select('t.type')
            ->from(Type::class, 't')
            ->where('t.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult(AbstractQuery::HYDRATE_SINGLE_SCALAR);
        return (string)$result ?? '';
    }

    public function getTypeIdsBySubstr(string $substr): array
    {
        $result = $this->entityManager->createQueryBuilder()
            ->select('t.id')
            ->from(Type::class, 't')
            ->where('t.type like :name')
            ->setParameter('name', '%'.$substr.'%')
            ->getQuery()
            ->getResult();
        return $result;
    }
}
