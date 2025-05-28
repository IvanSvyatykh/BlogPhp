<?php

namespace Pri301\Blog\Application\DTO\Requests;

class PublishPostRequest
{
    #[Assert\NotBlank(message: "Article id is required")]
    #[Assert\Type(type: 'numeric', message: 'Article id must be numeric')]
    public int $postId;

    #[Assert\NotBlank(message: "Category name is required")]
    public string $categoryName;
}