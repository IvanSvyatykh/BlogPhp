<?php

namespace Pri301\Blog\Application\DTO\Requests;

use Symfony\Component\Validator\Constraints as Assert;

class GetPostsByUserRequest
{
    #[Assert\NotBlank(message: "User login is required")]
    public string $user_login;
}
