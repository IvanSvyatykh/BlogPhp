<?php
namespace Pri301\Blog\Domain\Repository;


use Pri301\Blog\Domain\Entity\Tag;

interface TagRepositoryInterface{

    public function getAllTags(): array;
    public function addTag(Tag $tag): void;
    public function getTagIdByName(string $name): ?int;
    public function getTagsBySubstr(string $substr): array;
}