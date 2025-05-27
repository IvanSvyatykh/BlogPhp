<?php

namespace Pri301\Blog\Application\DTO\Requests;

use Symfony\Component\Validator\Constraints as Assert;

final class CreatePostRequest
{
    #[Assert\NotBlank(message: "Post title is required")]
    public string $title;
    #[Assert\NotBlank(message: "Post content is required")]
    public string $content;
    #[Assert\NotBlank(message: "Author login is required")]
    public string $authorLogin;
    #[Assert\NotBlank(message: "Post tags cannot be empty")]
    #[Assert\All([
        new Assert\Type('string'),
        new Assert\Length(max: 50),
    ])]
    public array $postTags;
}
