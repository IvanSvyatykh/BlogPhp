<?php

namespace Pri301\Blog\Domain\Services;



use Pri301\Blog\Domain\Entity\Post;

interface PostServiceInterface{

    public function createPost(array $data, int $authorId): Post;
    public function getPost(int $id): ?Post;
    public function getAllPosts(int $limit = 10, int $offset = 0): array;
    public function deletePost(int $id): void;
    public function getPublishedPostsByUser(int $userId): array;
    public function getUnpublishedPostsByUser(int $userId): array;
    public function rejectPost(int $postId): void;
    public function getPendingPosts(): array;
    public function getPostsBySubstrAtContent(string $substr): array;
    public function getPoststBySubstrAtTitle(string $substr): array;
}