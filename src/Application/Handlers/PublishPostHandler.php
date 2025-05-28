<?php

namespace Pri301\Blog\Application\Handlers;

use Pri301\Blog\Domain\Services\PostServiceInterface;
use Pri301\Blog\Domain\Services\UserServiceInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class PublishPostHandler
{
    public function __construct(
        private PostServiceInterface $postService,
    ){}

    public function __invoke(Request $request, Response $response): Response
    {
        $dto = $request->getAttribute('dto');
        $postId = $dto->postId;
        $this->postService->publishPost($postId);
        return $response->withStatus(204);
    }
}