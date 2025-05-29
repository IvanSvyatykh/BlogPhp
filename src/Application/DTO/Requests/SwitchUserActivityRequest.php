<?php

namespace Pri301\Blog\Application\DTO\Requests;

use Symfony\Component\Validator\Constraints as Assert;

class SwitchUserActivityRequest
{
    #[Assert\NotBlank(message: "User ID is required")]
    #[Assert\Type(type: "int")]
    public int $userId;

    #[Assert\NotNull(message: "Current status is required")]
    #[Assert\Type(type: "bool")]
    public bool $banned;
}