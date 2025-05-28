<?php

namespace Pri301\Blog\Application\Handlers;

use Pri301\Blog\Domain\Services\PostServiceInterface;
use Pri301\Blog\Domain\Services\UserServiceInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class PublishPostHandler
{


    public function __construct(private PostServiceInterface $postService){}


    public function __invoke(Request $request, Response $response): Response
    {
        $dto = $request->getAttribute("dto");
        $category = $this->postService->findCategoryByName($dto->categoryName);
        if (!$category) {
            return $this->json($response, ["error" => ["message" => "Category not found"]], 404);
        }

        $this->postService->publishPost($dto->postId, $category->getId());

        return $this->json($response, ['success' => true], 200);
    }

    private function json(Response $res, mixed $payload, int $status = 200): Response
    {
        $response = $res->withStatus($status);
        $response->getBody()->write(json_encode($payload, JSON_UNESCAPED_UNICODE));
        return $response->withHeader('Content-Type', 'application/json');
    }
}