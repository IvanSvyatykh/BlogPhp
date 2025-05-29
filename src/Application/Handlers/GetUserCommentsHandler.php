<?php

namespace Pri301\Blog\Application\Handlers;

use Pri301\Blog\Domain\Services\CommentServiceInterface;
use Pri301\Blog\Domain\Services\UserServiceInterface;
use Slim\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class GetUserCommentsHandler
{
    public function __construct(
        private readonly CommentServiceInterface $commentService,
        private readonly UserServiceInterface $userService,
    ) {
    }

    public function __invoke(Request $request, Response $response): Response
    {
        $dto = $request->getAttribute('dto');

        $login = $dto->userLogin;
        $user = $this->userService->getUserByLogin($login);

        if (!$user) {
            return $this->errorResponse('Author not found', 404);
        }

        $comments = $this->commentService->getCommentsByUser($user);
        return $this->json($response, $comments);
    }

    private function json(Response $res, mixed $payload, int $status = 200): Response
    {
        $response = $res->withStatus($status);
        $response->getBody()->write(json_encode($payload, JSON_UNESCAPED_UNICODE));
        return $response->withHeader('Content-Type', 'application/json');
    }

    private function errorResponse(string $msg, int $code): Response
    {
        $response = new Response($code);
        $response->getBody()->write(json_encode(['error' => ['message' => $msg]]));
        return $response->withHeader('Content-Type', 'application/json');
    }
}