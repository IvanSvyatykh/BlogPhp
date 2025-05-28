<?php

namespace Pri301\Blog\Application\DTO\Requests;

class CreateCommentRequest
{
    #[Assert\NotBlank(message: "Post id is required")]
    #[Assert\Type(type: 'numeric', message: 'Article id must be numeric')]
    public int $postId;

    #[Assert\NotBlank(message: "Login is required")]
    public string $userLogin;

    #[Assert\NotBlank(message: "Content is required")]
    public string $comment;
}