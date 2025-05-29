<?php

namespace Pri301\Blog\Application\DTO\Requests;

use Symfony\Component\Validator\Constraints as Assert;

class AdminPostRequest
{
    #[Assert\NotBlank(message: "Post ID is required")]
    #[Assert\Type(type: "int")]
    public int $postId;
}