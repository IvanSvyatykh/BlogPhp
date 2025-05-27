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

        $result = $this->registrationAndAuthorizationService->login(
            $dto->user_login,
            $dto->user_password
        );

        return $this->json($response, [
            'user_authorized_state' => $result->userAuthorizedState,
            'token' => $result->token
        ]);
    }

    private function json(Response $res, mixed $payload, int $status = 200): Response
    {
        $res = $res->withStatus($status);
        $res->getBody()->write(json_encode($payload, JSON_UNESCAPED_UNICODE));
        return $res->withHeader('Content-Type', 'application/json');
    }
}