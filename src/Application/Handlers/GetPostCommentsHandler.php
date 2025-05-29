<?php

namespace Pri301\Blog\Application\Handlers;

use Pri301\Blog\Domain\Services\CommentServiceInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class GetPostCommentsHandler
{
    public function __construct(
        private readonly CommentServiceInterface $commentService,
    ) {
    }

    public function __invoke(Request $request, Response $response): Response
    {
        $dto = $request->getAttribute('dto');

        $postId = $dto->postId;
        $comments = $this->commentService->getCommentsForPost($postId);
        return $this->json($response, $comments);
    }

    private function json(Response $res, mixed $payload, int $status = 200): Response
    {
        $response = $res->withStatus($status);
        $response->getBody()->write(json_encode($payload, JSON_UNESCAPED_UNICODE));
        return $response->withHeader('Content-Type', 'application/json');
    }
}