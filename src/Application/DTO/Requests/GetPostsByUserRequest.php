<?php

namespace Pri301\Blog\Application\DTO\Requests;

use Symfony\Component\Validator\Constraints as Assert;

class GetPostsByUserRequest
{
    #[Assert\NotBlank(message: "Substring is required")]
    #[Assert\Length(min: 0, max: 50)]
    public string $substring;

    #[Assert\NotBlank(message: "Article part is required")]
    #[Assert\Choice(
        choices: ["AUTHOR", "ARTICLE_TEXT", "ARTICLE_NAME", "NONE"],
        message: "Article part must be one of: AUTHOR, ARTICLE_TEXT, ARTICLE_NAME , NONE"
    )]
    public string $articlePart;
}
