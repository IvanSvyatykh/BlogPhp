<?php

namespace Pri301\Blog\DTO;

class GetCommentsByPostIdRequest
{
    #[Assert\NotBlank(message: "Post id is required")]
    public int $postId;
}