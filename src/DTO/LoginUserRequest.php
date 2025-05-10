<?php

namespace Pri301\Blog\DTO;

class LoginUserRequest
{
    #[Assert\NotBlank(message: "Login is required")]
    public string $user_login;

    #[Assert\NotBlank(message: "Password is required")]
    public string $user_password;
}