<?php

namespace Pri301\Blog\Domain\Services;

use Pri301\Blog\Domain\Entity\User;
use Pri301\Blog\Domain\Repository\TypeRepositoryInterface;
use Pri301\Blog\Domain\Repository\UserRepositoryInterface;


class TypeService implements TypeServiceInterface
{
    public function __construct(
        private TypeRepositoryInterface $typeRepository
    ) {
    }

    public function getTypeById(int $typeId): string
    {
        return $this->typeRepository->getTypeById($typeId);
    }

}