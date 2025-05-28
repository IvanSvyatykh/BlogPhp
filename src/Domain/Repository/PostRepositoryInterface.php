<?php

namespace Pri301\Blog\Domain\Repository;

use Pri301\Blog\Domain\Entity\Post;

interface PostRepositoryInterface
{
    public function findPostById(int $id): ?Post;
    public function findAllByUser(int $authorId , int $limit = 10, int $offset = 0): array;
    public function getArticlesByStatus(int $statusId , int $limit = 10, int $offset = 0 ): array;
    public function addPost(Post $post): int;
    public function deletePost(int $id): int;
    /**
     * @return Post[]
     */
    public function findPublishedByUserId(int $userId,int $publishStatusId): array;
    public function findUnpublishedByUserId(int $userId,int $publishStatusId): array;
    public function updatePostStatusById(int $postId, int $statusId): void;
    public function getPostBySubstrAtContent(string $substr): array;
    public function getPostsBySubstrAtTitle(string $substr): array;
}