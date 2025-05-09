<?php



namespace Pri301\Blog\Enums;

enum PostPart: string
{
    case author = 'AUTHOR';
    case articleText = 'ARTICLE_TEXT';
    case articleName = 'ARTICLE_NAME';
}
