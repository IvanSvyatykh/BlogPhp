<?php


namespace Pri301\Blog\Infarastructure\Doctrine\Repositories;

use Doctrine\ORM\EntityManagerInterface;
use Pri301\Blog\Domain\Entity\Status;
use Pri301\Blog\Domain\Enum\PostStatus;

class StatusRepository
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
            ->getSingleScalarResult();
    }

    public function getPendingStatusId(): ?int{
        return $this->entityManager
            ->createQueryBuilder()
            ->select('s.id')
            ->from(Status::class, 's')
            ->where('s.status := status')
            ->setParameter('status', PostStatus::Pending)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function getRejectedStatusId(): ?int{
        return $this->entityManager
            ->createQueryBuilder()
            ->select('s.id')
            ->from(Status::class, 's')
            ->where('s.status := status')
            ->setParameter('status', PostStatus::Rejected)
            ->getQuery()
            ->getSingleScalarResult();
    }
}