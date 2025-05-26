<?php

namespace Pri301\Blog\Application\DTO\Requests;

final class GetUnpublishedPostsRequest
{
    #[Assert\NotBlank(message: 'Author login is required')]
    public string $userLogin;
}