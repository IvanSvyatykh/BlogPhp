<?php
namespace Pri301\Blog\Handlers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Pri301\Blog\Services\PostService;


final class PostHandler
{

    private PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function getPostsBySubstr(Request $request, Response $response)
    {
        $dto = $request->getAttribute('dto');

        $substring = $dto->substring;
        $articlePart = $dto->articlePart;

        $result = [
            'substring' => $substring,
            'articlePart' => $articlePart,
            'posts' => ["Test"]
        ];

        $response->getBody()->write(json_encode($result));
        return $response->withHeader('Content-Type', 'application/json');

    }

    public function getPublishPosts(Request $request, Response $response)
    {
        $posts = $this->postService->getAllPosts();

        $postsArray = array_map(function ($post) {
            return [
                'id' => $post->getId(),
                'title' => $post->getTitle(),
                'author_id' => $post->getAuthorId(),
                'created_at' => $post->getCreatedAt()->format('Y-m-d H:i:s'),
            ];
        }, $posts);

        $response->getBody()->write(json_encode([
            'posts' => $postsArray
        ]));

        return $response->withHeader('Content-Type', 'application/json');
    }

    public function getPendingPosts(Request $request, Response $response)
    {
        $posts = $this->postService->getPendingPosts();

        $postsArray = array_map(function ($post) {
            return [
                'id' => $post->getId(),
                'title' => $post->getTitle(),
                'author_id' => $post->getAuthorId(),
                'created_at' => $post->getCreatedAt()->format('Y-m-d H:i:s'),
            ];
        }, $posts);

        $response->getBody()->write(json_encode([
            'posts' => $postsArray
        ]));

        return $response->withHeader('Content-Type', 'application/json');
    }

    public function rejectPost(Request $request, Response $response, array $args)
    {
        $postId = $args['postId'];
        $this->postService->rejectPost($postId);
        $response->getBody()->write(json_encode(['success' => true]));

        return $response->withHeader('Content-Type', 'application/json');
    }

    public function publishPost(Request $request, Response $response, array $args)
    {
        $postId = $args['postId'];
        $this->postService->publishPost($postId);
        $response->getBody()->write(json_encode(['success' => true]));

        return $response->withHeader('Content-Type', 'application/json');
    }
}