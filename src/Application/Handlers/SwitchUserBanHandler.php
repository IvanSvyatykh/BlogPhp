<?php

namespace Pri301\Blog\Application\Handlers;

use Pri301\Blog\Domain\Services\UserServiceInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class SwitchUserBanHandler
{
    public function __construct(
        private UserServiceInterface $userService,
    ){}
    public function __invoke(Request $request, Response $response): Response
    {
        $dto = $request->getAttribute('dto');

        $userId = $dto->userId;
        $banned = $dto->banned;

        $this->userService->switchBanUser($userId, $banned);
        return $response->withStatus(204);
    }
}