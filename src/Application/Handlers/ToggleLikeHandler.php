<?php

namespace Pri301\Blog\Application\Handlers;


use Pri301\Blog\Domain\Services\LikeServiceInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class ToggleLikeHandler
{
    public function __construct(
        private LikeServiceInterface $likeService,
    ){}

    public function __invoke(Request $request, Response $response): Response
    {
        $dto = $request->getAttribute('dto');

        $result = $this->likeService->toggleLike($dto->articleId, $dto->userLogin);

        return $this->json($response, ['like' => $result], 201);
    }

    private function json(Response $res, mixed $payload, int $status = 200): Response
    {
        $response = $res->withStatus($status);
        $response->getBody()->write(json_encode($payload, JSON_UNESCAPED_UNICODE));
        return $response->withHeader('Content-Type', 'application/json');
    }
}