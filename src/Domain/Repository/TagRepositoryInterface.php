<?php
namespace Pri301\Blog\Domain\Repository;


interface TagRepositoryInterface{

    public function getAllTags(): array;
}