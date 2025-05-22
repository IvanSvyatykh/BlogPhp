<?php

namespace Pri301\Blog\Domain\Services;

use Cassandra\Type;
use Doctrine\ORM\EntityManager;
use Pri301\Blog\Domain\Entity\Post;
use Pri301\Blog\Domain\Entity\User;
use Pri301\Blog\Domain\Enum\PostStatus;
use Pri301\Blog\Domain\Repository\PostRepositoryInterface;
use Pri301\Blog\Domain\Repository\StatusRepositoryInterface;

class PostService implements PostServiceInterface
{
    public function __construct(
        private PostRepositoryInterface $postRepository,
        private EntityManager $entityManager,
        private StatusRepositoryInterface $statusRepository
    ) {}

    public function createPost(array $data, int $authorId): Post
    {

        $post = new Post(
            $data['title'],
            $data['content'],
            $this->entityManager->getReference(User::class, $authorId),
            $this->entityManager->getReference(PostStatus::class, $data['status']),
            $this->entityManager->getReference(Type::class, $data['type'])
        );

        $this->postRepository->addPost($post);
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
        $this->postRepository->deletePost($id);
    }
    public function getAllPostsByUser(int $authorId, int $limit = 10, int $offset = 0): array
    {
        return $this->postRepository->findAllByUser($authorId, $limit, $offset);
    }

    public function publishPost(int $postId): void
    {
        $post = $this->postRepository->findPostById($postId);
        if ($post) {
            $post->setPublished(true);
            $this->postRepository->addPost($post);
        }
    }

    public function getPublishedPostsByUser(int $userId): array
    {
        $publishedStatusId = $this->statusRepository->getPublishStatusId();
        return $this->postRepository->findPublishedByUserId($userId,$publishedStatusId);
    }

    public function getUnpublishedPostsByUser(int $userId): array
    {
        $publishStatusId = $this->statusRepository->getPublishStatusId();
        return $this->postRepository->findUnpublishedByUserId($userId,$publishStatusId);
    }

    public function rejectPost(int $postId): void
    {
        $post = $this->postRepository->findPostById($postId);
        $rejectedStatusId = $this->statusRepository->getRejectedStatusId();
        $post->setStatus($this->entityManager->getReference(PostStatus::class, $rejectedStatusId));
        $this->postRepository->updatePostStatus($post);
    }

    public function getPendingPosts(int $limit = 10, int $offset = 0): array
    {
        $pendingStatusId = $this->statusRepository->getPendingStatusId();
        return $this->postRepository->getArticlesByStatus($pendingStatusId,$limit,$offset);
    }

}