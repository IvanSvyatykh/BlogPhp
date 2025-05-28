<?php


namespace Pri301\Blog\Infrastructure\Doctrine\Repositories;
use Doctrine\ORM\AbstractQuery;
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

    public function addTag(Tag $tag): void
    {
        $this->entityManager->persist($tag);
        $this->entityManager->flush();

    }

    public function getTagIdByName(string $name): ?int
    {
        $result = $this->entityManager
            ->createQueryBuilder()
            ->select('t.id')
            ->from(Tag::class, 't')
            ->where('t.tag = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->getOneOrNullResult(AbstractQuery::HYDRATE_SINGLE_SCALAR);

        return $result ? (int) $result : null;
    }


}