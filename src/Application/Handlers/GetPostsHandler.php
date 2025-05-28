<?php
namespace Pri301\Blog\Application\Handlers;

use Pri301\Blog\Domain\Services\PostServiceInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class GetPostsHandler
{
    public function __construct(
        private PostServiceInterface $postService,
    ){}

    public function __invoke(Request $request, Response $response): Response
    {
        $posts = $this->postService->getAllPosts();
        if (empty($posts)) {
            error_log('No posts found');
        }

        return $this->json($response, $posts);
    }

    private function json(Response $res, mixed $payload, int $status = 200): Response
    {
        $response = $res->withStatus($status);
        $response->getBody()->write(json_encode($payload, JSON_UNESCAPED_UNICODE));
        return $response->withHeader('Content-Type', 'application/json');
    }
}