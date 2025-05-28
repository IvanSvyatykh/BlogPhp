<?php


namespace Pri301\Blog\Application\DTO\Requests;

use Pri301\Blog\Domain\Enum\PostPart;
use Symfony\Component\Validator\Constraints as Assert;

final class GetPostsBySubstrRequest
{
    #[Assert\NotBlank(message: "Substr is required")]
    public string $substr;
    #[Assert\NotBlank(message: "Post part is required")]
    #[Assert\Choice(
        callback: [PostPart::class, 'getValues'],
        message: "Invalid post part. Must be one of: {{ choices }}"
    )]
    public string $part;
}