<?php


namespace Pri301\Blog\Domain\Enum;

enum PostPart: string

{
    case Author = 'AUTHOR';
    case ArticleText = 'ARTICLE_TEXT';
    case Article_name = 'ARTICLE_NAME';

    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }
}