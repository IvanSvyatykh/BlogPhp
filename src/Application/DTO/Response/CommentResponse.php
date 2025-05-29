<?php

namespace Pri301\Blog\Application\DTO\Response;

class CommentResponse
{
    public function __construct(
        public int $comment_id,
        public string $comment_text,
        public string $comment_author_login,
        public string $comment_author_name
    ) {
    }
}