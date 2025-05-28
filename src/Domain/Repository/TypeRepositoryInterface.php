<?php


namespace Pri301\Blog\Domain\Repository;



use Pri301\Blog\Domain\Entity\Type;

interface TypeRepositoryInterface
{
    public function getAllTypes(): array;
    public function findCategoryByName(string $name): ?Type;
    public function getTypeById(int $id):string;

    public function getTypeIdsBySubstr(string $substr): array;

}