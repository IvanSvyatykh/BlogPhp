<?php

namespace Pri301\Blog\Application\DTO\Requests;

use Pri301\Blog\DTO\Assert;

class GetCommentsByPostIdRequest
{
    #[Assert\NotBlank(message: "Post id is required")]
    public int $postId;
}