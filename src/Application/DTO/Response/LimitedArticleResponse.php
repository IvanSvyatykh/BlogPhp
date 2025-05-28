<?php

namespace Pri301\Blog\Application\DTO\Response;

class LimitedArticleResponse
{
    public function __construct(
        public readonly int $article_id,
        public readonly string $article_name,
        public readonly string $article_text,
        public readonly string $author_login,
        public readonly string $author_name,
        public readonly int $article_likes_count)
    {

    }
}
