<?php

namespace Pri301\Blog\Domain\Services;

use Cassandra\Type;
use Doctrine\ORM\EntityManager;
use Pri301\Blog\Domain\Entity\Post;
use Pri301\Blog\Domain\Entity\Status;
use Pri301\Blog\Domain\Entity\User;
use Pri301\Blog\Domain\Enum\PostStatus;
use Pri301\Blog\Domain\Repository\PostRepositoryInterface;
use Pri301\Blog\Domain\Repository\StatusRepositoryInterface;
use Pri301\Blog\Domain\Repository\TagRepositoryInterface;

class PostService implements PostServiceInterface
{
    public function __construct(
        private PostRepositoryInterface $postRepository,
        private EntityManager $entityManager,
        private StatusRepositoryInterface $statusRepository,
        private TagRepositoryInterface $tagRepository
    ) {}

    public function createPost(array $data, int $authorId): Post
    {
        $pendingStatusId = $this->statusRepository->getPendingStatusId();
        $post = new Post(
            $data['title'],
            $data['content'],
            $this->entityManager->getReference(User::class, $authorId),
            $this->entityManager->getReference(Status::class, $pendingStatusId),
        );

        $postId = $this->postRepository->addPost($post);
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

    public function getAllPostsByUser(int $authorId, int $limit = 10, int $offset = 0): array
    {
        return $this->postRepository->findAllByUser($authorId, $limit, $offset);
    }

    public function getPublishedPostsByUser(int $userId): array
    {
        $publishedStatusId = $this->statusRepository->getPublishStatusId();
        return $this->postRepository->findPublishedByUserId($userId, $publishedStatusId);
    }

    public function getUnpublishedPostsByUser(int $userId): array
    {
        $publishStatusId = $this->statusRepository->getPublishStatusId();
        return $this->postRepository->findUnpublishedByUserId($userId,$publishStatusId);
    }

    public function rejectPost(int $postId): void
    {
        $rejectedStatusId = $this->statusRepository->getRejectedStatusId();
        $this->postRepository->updatePostStatusById($postId, $rejectedStatusId);
    }

    public function getPendingPosts(int $limit = 10, int $offset = 0): array
    {
        $pendingStatusId = $this->statusRepository->getPendingStatusId();
        return $this->postRepository->getArticlesByStatus($pendingStatusId,$limit,$offset);
    }

    public function getPostsBySubstrAtContent(string $substr): array
    {
        $result =  $this->postRepository->getPostBySubstrAtContent($substr);
        return  $result;
    }

    public function getPostsBySubstrAtTitle(string $substr): array
    {
        $result =  $this->postRepository->getPostsBySubstrAtTitle($substr);
        return  $result;
    }
}