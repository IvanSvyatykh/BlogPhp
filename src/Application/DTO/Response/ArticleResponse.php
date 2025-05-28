<?php

namespace Pri301\Blog\Application\DTO\Response;

class ArticleResponse
{
    public function __construct(
        public readonly int $article_id,
        public readonly string $article_title,
        public readonly string $article_text,
        public readonly string $author_login,
        public readonly string $author_name,
        public readonly string $article_category,
        public readonly array $article_tags,
        public readonly int $article_likes_count)
    {

    }
}
