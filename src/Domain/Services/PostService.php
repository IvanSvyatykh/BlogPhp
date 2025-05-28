<?php

namespace Pri301\Blog\Domain\Services;

use Doctrine\ORM\EntityManager;
use Pri301\Blog\Domain\Entity\Post;
use Pri301\Blog\Domain\Entity\PostTag;
use Pri301\Blog\Domain\Entity\Status;
use Pri301\Blog\Domain\Entity\Tag;
use Pri301\Blog\Domain\Entity\User;
use Pri301\Blog\Domain\Entity\Type;
use Pri301\Blog\Domain\Enum\PostStatus;
use Pri301\Blog\Domain\Repository\PostRepositoryInterface;
use Pri301\Blog\Domain\Repository\PostTagsRepositoryInterface;
use Pri301\Blog\Domain\Repository\StatusRepositoryInterface;
use Pri301\Blog\Domain\Repository\TagRepositoryInterface;
use Pri301\Blog\Domain\Repository\TypeRepositoryInterface;
use Pri301\Blog\Domain\Repository\UserRepositoryInterface;

class PostService implements PostServiceInterface
{
    public function __construct(
        private PostRepositoryInterface $postRepository,
        private EntityManager $entityManager,
        private StatusRepositoryInterface $statusRepository,
        private TagRepositoryInterface $tagRepository,
        private PostTagsRepositoryInterface $postTagsRepository,
        private TypeRepositoryInterface $typeRepository
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
        $tags = $data['tags'];
        foreach ($tags as $tag_name) {

            $tagId = $this->tagRepository->getTagIdByName($tag_name);
            if (!$tagId) {
                $tag = new Tag($tag_name);
                $this->tagRepository->addTag($tag);
                $tagId = $tag->getId();            }
            $postTag = new PostTag($post,$this->entityManager->getReference(Tag::class, $tagId));
            $this->postTagsRepository->addTag($postTag);
        }

        return $post;
    }

    public function getPost(int $id): ?Post
    {
        return $this->postRepository->findPostById($id);
    }


    public function getAllPosts(int $limit = 10, int $offset = 0): array
    {
        return $this->postRepository->findAll($limit, $offset);
    }

    public function getAllPostsByUser(int $authorId, int $limit = 10, int $offset = 0): array
    {
        return $this->postRepository->findAllByUser($authorId, $limit, $offset);
    }
    /**
     * @return Post[]
     */
    public function getPublishedPostsByUser(int $userId): array
    {
        $publishedStatusId = $this->statusRepository->getPublishStatusId();
        return $this->postRepository->findPublishedByUserId($userId, $publishedStatusId);
    }

    public function getUnpublishedPostsByUser(int $userId): array
    {
        $publishStatusId = $this->statusRepository->getPendingStatusId();
        return $this->postRepository->findUnpublishedByUserId($userId,$publishStatusId);
    }

    public function rejectPost(int $postId): void
    {
        $rejectedStatusId = $this->statusRepository->getRejectedStatusId();
        $post->setStatus($this->entityManager->getReference(Status::class, $rejectedStatusId));
        $this->postRepository->updatePostStatus($post);
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

    public function publishPost(int $postId , int $categoryId): void
    {
        $post = $this->postRepository->findPostById($postId);
        $publishStatusId = $this->statusRepository->getPublishStatusId();
        $post->setStatus($this->entityManager->getReference(Status::class, $publishStatusId));
        $this->postRepository->updatePostStatus($post);
    }

    public function getAllCategories(): array
    {
        return $this->typeRepository->getAllTypes();
    }

    public function findCategoryByName(string $categoryName): ?Type
    {
        return $this->typeRepository->findCategoryByName($categoryName);
    }


    public function getAllUnpublishedPosts(): array
    {
        $pendingStatusId = $this->statusRepository->getPendingStatusId();
        return $this->postRepository->getUnpublished($pendingStatusId);
    }

}