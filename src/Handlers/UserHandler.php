<?php

namespace Pri301\Blog\Handlers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Pri301\Blog\Services\UserService;

final class UserHandler
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function switchBannedUser(Request $request, Response $response, array $args)
    {
       $userId = $args['userId'];
       $this->userService->switchBanUser($userId);
       $response->getBody()->write(json_encode(['success' => true]));

       return $response->withHeader('Content-Type', 'application/json');
    }

    public function getUsersList(Request $request, Response $response)
    {
        $users = $this->userService->getUsersList();

        $usersArray = array_map(function ($user) {
            return [
                'id' => $user->getId(),
                'username' => $user->getUsername(),
                'login' => $user->getLogin(),
                'isBanned' => $user->isBanned(),
                'isAdmin' => $user->isAdmin(),
                'createdAt' => $user->getCreatedAt()->format('Y-m-d H:i:s'),
            ];
        }, $users);

        $response->getBody()->write(json_encode(['users' => $usersArray]));
        return $response->withHeader('Content-Type', 'application/json');
    }
}