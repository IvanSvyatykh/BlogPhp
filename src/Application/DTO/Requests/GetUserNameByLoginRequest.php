<?php

namespace Pri301\Blog\Application\DTO\Requests;

use Pri301\Blog\DTO\Assert;

class GetUserNameByLoginRequest
{
    #[Assert\NotBlank(message: "Login is required")]
    public string $user_login;
}