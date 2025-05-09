<?php


namespace Pri301\Blog\DTO;

use Symfony\Component\Validator\Constraints as Assert;


class GetPostsRequest
{
    #[Assert\NotBlank(message: "Substring is required")]
    #[Assert\Length(min: 0, max: 50)]
    public string $substring;

    #[Assert\NotBlank(message: "Email is required")]
    #[Assert\Email(message: "Invalid email format")]
    public string $email;
}