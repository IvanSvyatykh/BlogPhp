<?php

namespace Pri301\Blog\Application\DTO\Requests;

use Symfony\Component\Validator\Constraints as Assert;

final class GetUserCommentsRequest
{
    #[Assert\NotBlank(message: "User login is required")]
    public string $userLogin;
}