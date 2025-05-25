<?php


namespace Pri301\Blog\Infrastructure\Doctrine\Repositories;

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

    public function getPublishStatusId(): ?int{
        return $this->entityManager
            ->createQueryBuilder()
            ->select('s.id')
            ->from(Status::class, 's')
            ->where('s.status := status')
            ->setParameter('status', PostStatus::Published)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getPendingStatusId(): ?int{
        return $this->entityManager
            ->createQueryBuilder()
            ->select('s.id')
            ->from(Status::class, 's')
            ->where('s.status := status')
            ->setParameter('status', PostStatus::Pending)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getRejectedStatusId(): ?int{
        return $this->entityManager
            ->createQueryBuilder()
            ->select('s.id')
            ->from(Status::class, 's')
            ->where('s.status := status')
            ->setParameter('status', PostStatus::Rejected)
            ->getQuery()
            ->getOneOrNullResult();
    }
}