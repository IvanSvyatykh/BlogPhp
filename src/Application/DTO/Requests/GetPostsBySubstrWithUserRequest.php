<?php


namespace Pri301\Blog\Application\DTO\Requests;

use Symfony\Component\Validator\Constraints as Assert;

class GetPostsBySubstrWithUserRequest
{
    #[Assert\Length(min: 0, max: 50)]
    public string $substring;

    #[Assert\NotBlank(message: "Article part is required")]
    #[Assert\Choice(
        choices: ["ARTICLE_TAG", "ARTICLE_TEXT", "ARTICLE_NAME" , "NONE","ARTICLE_CATEGORY"],
        message: "Article part must be one of:  ARTICLE_TEXT, ARTICLE_NAME , NONE"
    )]
    public string $articlePart;

    #[Assert\NotBlank(message: "User login is required")]
    public string $userLogin;
}