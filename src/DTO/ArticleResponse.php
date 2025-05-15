<?php

namespace Pri301\Blog\DTO;

class ArticleResponse
{
    public function __construct(
        public int $article_id,
        public string $article_name,
        public string $article_text,
        public string $author_login,
        public string $author_name,
        public int $article_likes_count = 0
    ) {}
}
