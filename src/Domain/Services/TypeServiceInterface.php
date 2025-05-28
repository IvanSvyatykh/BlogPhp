<?php
namespace Pri301\Blog\Domain\Services;


use Pri301\Blog\Application\DTO\Response\LoginUserResponse;
use Pri301\Blog\Application\DTO\Response\RegisterUserResponse;

interface TypeServiceInterface
{
    public function getTypeById(int $typeId): string;

}