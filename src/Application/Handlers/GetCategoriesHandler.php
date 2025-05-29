<?php

namespace Pri301\Blog\Application\Handlers;

use Pri301\Blog\Domain\Services\PostServiceInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class GetCategoriesHandler
{
    public function __construct(
        private readonly PostServiceInterface $postService
    ) {
    }

    public function __invoke(Request $request, Response $response): Response
    {
        $categories = $this->postService->getAllCategories();
        $categories_names = array_column($categories, 'type');
        return $this->json($response, $categories_names);
    }

    private function json(Response $res, mixed $payload, int $status = 200): Response
    {
        $response = $res->withStatus($status);
        $response->getBody()->write(json_encode($payload, JSON_UNESCAPED_UNICODE));
        return $response->withHeader('Content-Type', 'application/json');
    }
}