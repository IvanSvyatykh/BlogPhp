<?php
namespace Pri301\Blog\Domain\Services;



use Pri301\Blog\Domain\Entity\Post;

interface PostTagsServiceInterface
{

    public function getTagsByPostId(int $postId): array;

}