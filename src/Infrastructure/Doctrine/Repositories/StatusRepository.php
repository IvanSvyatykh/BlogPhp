<?php


namespace Pri301\Blog\Infrastructure\Doctrine\Repositories;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManagerInterface;
use Pri301\Blog\Domain\Entity\Status;
use Pri301\Blog\Domain\Enum\PostStatus;
use Pri301\Blog\Domain\Repository\StatusRepositoryInterface;

class StatusRepository implements StatusRepositoryInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getPublishStatusId(): ?int
    {
        $result = $this->entityManager
            ->createQueryBuilder()
            ->select('s.id')
            ->from(Status::class, 's')
            ->where('s.status = :status')
            ->setParameter('status', PostStatus::Published->value)
            ->getQuery()
            ->getOneOrNullResult(AbstractQuery::HYDRATE_SINGLE_SCALAR);

        return $result ? (int)$result : null;
    }

    public function getPendingStatusId(): ?int
    {
        $result = $this->entityManager
            ->createQueryBuilder()
            ->select('s.id')
            ->from(Status::class, 's')
            ->where('s.status = :status')
            ->setParameter('status', PostStatus::Pending->value)
            ->getQuery()
            ->getOneOrNullResult(AbstractQuery::HYDRATE_SINGLE_SCALAR);
        return $result ? (int)$result : null;
    }

    public function getRejectedStatusId(): ?int
    {
        $result = $this->entityManager
            ->createQueryBuilder()
            ->select('s.id')
            ->from(Status::class, 's')
            ->where('s.status = :status')
            ->setParameter('status', PostStatus::Rejected->value)
            ->getQuery()
            ->getOneOrNullResult(AbstractQuery::HYDRATE_SINGLE_SCALAR);

        return $result ? (int)$result : null;
    }
}