<?php


namespace Pri301\Blog\Infarastructure\Doctrine\Repositories;

use Doctrine\ORM\EntityManagerInterface;
use Pri301\Blog\Domain\Entity\Tag;

class TagRepository
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