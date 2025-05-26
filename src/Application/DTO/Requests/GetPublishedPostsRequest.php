<?php

namespace Pri301\Blog\Application\DTO\Requests;

use Symfony\Component\Validator\Constraints as Assert;

final class GetPublishedPostsRequest
{
    #[Assert\NotBlank(message: 'Author login is required')]
    public string $userLogin;
}