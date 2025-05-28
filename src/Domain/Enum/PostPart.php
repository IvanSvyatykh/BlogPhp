<?php


namespace Pri301\Blog\Domain\Enum;

enum PostPart: string

{
    case Author = 'AUTHOR';
    case ArticleText = 'ARTICLE_TEXT';
    case Article_name = 'ARTICLE_NAME';
    case Tag = 'ARTICLE_TAG';
    case Type = 'ARTICLE_CATEGORY';

    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }
}