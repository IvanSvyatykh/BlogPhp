<?php

namespace Pri301\Blog\Domain\Services;



use Pri301\Blog\Domain\Entity\Post;

interface PostServiceInterface{

    public function createPost(array $data, int $authorId): Post;
    public function getPost(int $id): ?Post;
    public function getAllPosts(): array;
    public function deletePost(int $id): void;
    public function getPublishedPostsByUser(int $userId): array;
    public function getUnpublishedPostsByUser(int $userId): array;
    public function rejectPost(int $postId): void;
    public function getPendingPosts(): array;
    public function getPostsBySubstrAtContent(string $substr): array;
    public function getPostsBySubstrAtTitle(string $substr): array;
    public function publishPost(int $postId): void;
}