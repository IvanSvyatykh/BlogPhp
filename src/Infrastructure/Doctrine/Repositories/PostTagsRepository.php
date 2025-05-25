<?php
namespace Pri301\Blog\Infrastructure\Doctrine\Repositories;


use Doctrine\ORM\EntityManagerInterface;
use Pri301\Blog\Domain\Entity\Post;
use Pri301\Blog\Domain\Entity\PostTag;
use Pri301\Blog\Domain\Entity\Tag;
use Pri301\Blog\Domain\Repository\PostTagsRepositoryInterface;

class PostTagsRepository implements PostTagsRepositoryInterface{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public function addTag(PostTag $postTag) : int
    {

        $this->entityManager->persist($postTag);
        $this->entityManager->flush();
        return $postTag->getId();
    }
}