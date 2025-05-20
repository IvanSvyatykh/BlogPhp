<?php


namespace Pri301\Blog\Infarastructure\Doctrine\Repositories;

use Doctrine\ORM\EntityManagerInterface;
use Pri301\Blog\Domain\Entity\Tag;
use Pri301\Blog\Domain\Repository\TagRepositoryInterface;

class TagRepository implements TagRepositoryInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getAllTags(): array
    {
        return $this->entityManager
            ->createQueryBuilder()
            ->select('t')
            ->from(Tag::class, 't')
            ->getQuery()
            ->getSingleScalarResult();
    }

}