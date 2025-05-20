<?php

namespace Pri301\Blog\Application\DTO\Requests;

use Symfony\Component\Validator\Constraints as Assert;

class PublishPostRequest
{
    #[Assert\NotBlank(message: "Post title is required")]
    public string $name;

    #[Assert\NotBlank(message: "Post content is required")]
    public string $content;

    #[Assert\NotBlank(message: "Author login is required")]
    public string $author_login;
}