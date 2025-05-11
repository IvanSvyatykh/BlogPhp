<?php

namespace Pri301\Blog\Services;

use Pri301\Blog\Enteties\Post;
use Pri301\Blog\Repositories\PostRepository;

class PostService
{
    public function __construct(
        private PostRepository $postRepository
    ) {}

    public function createPost(array $data, int $authorId): Post
    {

        $post = new Post(
            $data['title'],
            $data['content'],
            $authorId
        );

        $this->postRepository->save($post);
        return $post;
    }

    public function getPost(int $id): ?Post
    {
        return $this->postRepository->find($id);
    }

    public function getAllPosts(int $limit = 10, int $offset = 0): array
    {
        return $this->postRepository->findAll($limit, $offset);
    }

    public function deletePost(int $id): void
    {
        $this->postRepository->delete($id);
    }

    public function publishPost(int $postId): void
    {
        $post = $this->postRepository->find($postId);
        if ($post) {
            $post->setPublished(true);
            $this->postRepository->save($post);
        }
    }

    public function getPublishedPostsByUser(int $userId): array
    {
        return $this->postRepository->findPublishedByUserId($userId);
    }

    public function getUnpublishedPostsByUser(int $userId): array
    {
        return $this->postRepository->findUnpublishedByUserId($userId);
    }
}