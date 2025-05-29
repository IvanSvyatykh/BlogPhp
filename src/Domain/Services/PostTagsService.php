<?php


namespace Pri301\Blog\Domain\Services;

use Cassandra\Type;
use Doctrine\ORM\EntityManager;
use Pri301\Blog\Domain\Entity\Post;
use Pri301\Blog\Domain\Entity\PostTag;
use Pri301\Blog\Domain\Entity\Status;
use Pri301\Blog\Domain\Entity\Tag;
use Pri301\Blog\Domain\Entity\User;
use Pri301\Blog\Domain\Enum\PostStatus;
use Pri301\Blog\Domain\Repository\PostRepositoryInterface;
use Pri301\Blog\Domain\Repository\PostTagsRepositoryInterface;
use Pri301\Blog\Domain\Repository\StatusRepositoryInterface;
use Pri301\Blog\Domain\Repository\TagRepositoryInterface;

class PostTagsService implements PostTagsServiceInterface
{
    public function __construct(
        private readonly PostTagsRepositoryInterface $postTagsRepository
    ) {
    }

    public function getTagsByPostId(int $postId): array
    {
        return $this->postTagsRepository->getAllPostTags($postId);
    }

}