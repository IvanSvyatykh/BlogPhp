<?php

namespace Pri301\Blog\Application\DTO\Requests;

class ToggleLikeRequest
{
    #[Assert\NotBlank(message: "Post id is required")]
    #[Assert\Type(type: 'numeric', message: 'Article id must be numeric')]
    public int $articleId;

    #[Assert\NotBlank(message: "Login is required")]
    public string $userLogin;
}