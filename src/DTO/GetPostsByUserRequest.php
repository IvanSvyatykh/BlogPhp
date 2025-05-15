<?php

namespace Pri301\Blog\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class GetPostsByUserRequest
{
    #[Assert\NotBlank(message: "User login is required")]
    public string $user_login;
}
