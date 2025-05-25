<?php

namespace Pri301\Blog\Application\DTO\Requests;

final class DeletePostRequest
{
    #[Assert\NotBlank(message: 'Article id is required')]
    #[Assert\Type(type: 'numeric', message: 'Article id must be numeric')]
    public int $articleId;
    #[Assert\NotBlank(message: 'Author login is required')]
    public string $userLogin;
}