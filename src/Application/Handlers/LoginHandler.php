<?php

namespace Pri301\Blog\Application\Handlers;


use Pri301\Blog\Domain\Enum\UserAuthState;
use Pri301\Blog\Domain\Services\RegistrationAndAuthorizationServiceInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


final class LoginHandler
{
    public function __construct(
        private RegistrationAndAuthorizationServiceInterface $registrationAndAuthorizationService,
    ){}

    public function __invoke(Request $request, Response $response): Response
    {
        $dto = $request->getAttribute('dto');

        $result = $this->registrationAndAuthorizationService->login($dto->user_login, $dto->user_password);
        $response->getBody()->write(json_encode([
            'user_authorized_state' => $result->userAuthorizedState,
            'token' => $result->token
        ]));
        if ($result->userAuthorizedState === UserAuthState::USER_NOT_AUTHORIZED) {
            return $response->withHeader('Content-Type', 'application/json')->withStatus(401);
        }
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}