<?php

namespace Pri301\Blog\Domain\Services;

use Pri301\Blog\Domain\Entity\Post;
use Pri301\Blog\Domain\Enum\PostStatus;
use Pri301\Blog\Infarastructure\Doctrine\Repositories\PostRepository;

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

        $this->postRepository->add($post);
        return $post;
    }

    public function getPost(int $id): ?Post
    {
        return $this->postRepository->findPostById($id);
    }

    public function getAllPosts(int $limit = 10, int $offset = 0): array
    {
        return $this->postRepository->getArticlesByStatus($limit, $offset);
    }

    public function deletePost(int $id): void
    {
        $this->postRepository->delete($id);
    public function getAllPostsByUser(int $authorId, int $limit = 10, int $offset = 0): array
    {
        return $this->postRepository->findAllByUser($authorId, $limit, $offset);
    }

    public function publishPost(int $postId): void
    {
        $post = $this->postRepository->findPostById($postId);
        if ($post) {
            $post->setPublished(true);
            $this->postRepository->add($post);
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
        $post->setStatus(PostStatus::Published);
        $this->postRepository->add($post);
    }

    public function rejectPost(int $postId): void
    {
        $post = $this->postRepository->findPostById($postId);
        $post->setStatus(PostStatus::Rejected);
        $this->postRepository->add($post);
    }

    public function getPendingPosts(): array
    {
        return $this->postRepository->getPendingArticles();
    }

}