<?php

namespace Pri301\Blog\Application\Handlers;

use Pri301\Blog\Domain\Services\UserServiceInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class GetUsersHandler
{
    public function __construct(
        private UserServiceInterface $userService,
    ){}

    public function __invoke(Request $request, Response $response) : Response
    {
        $userList = $this->userService->getUsersList();
        return $this->json($response, $userList);
    }

    private function json(Response $res, mixed $payload, int $status = 200): Response
    {
        $response = $res->withStatus($status);
        $response->getBody()->write(json_encode($payload, JSON_UNESCAPED_UNICODE));
        return $response->withHeader('Content-Type', 'application/json');
    }
}