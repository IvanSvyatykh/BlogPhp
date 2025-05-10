<?php

namespace Pri301\Blog\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class RegisterUserRequest
{
    #[Assert\NotBlank(message: "Username is required")]
    public string $user_name;

    #[Assert\NotBlank(message: "Login is required")]
    public string $user_login;

    #[Assert\NotBlank(message: "Password is required")]
    public string $user_password;
}
