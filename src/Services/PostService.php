<?php

namespace Pri301\Blog\Services;

use app\repositories\PostRepository;
use Pri301\Blog\Enteties\Post;

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
}