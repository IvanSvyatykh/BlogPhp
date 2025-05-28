<?php
namespace Pri301\Blog\Domain\Repository;



use Pri301\Blog\Domain\Entity\PostTag;


interface PostTagsRepositoryInterface{
    public function addTag(PostTag $postTag): int;
    public function getAllPostTags(int $postId): array;
    public function getPostsIdsByTag(array $tagsIds): array;
}