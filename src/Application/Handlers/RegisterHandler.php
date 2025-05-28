<?php

namespace Pri301\Blog\Application\Handlers;

use Pri301\Blog\Domain\Services\RegistrationAndAuthorizationServiceInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Psr7\Response;

final class RegisterHandler
{
    public function __construct(
        private RegistrationAndAuthorizationServiceInterface $registrationAndAuthorizationService,
    )
    {
    }

    public function __invoke(Request $request, Response $response): Response
    {
        $dto = $request->getAttribute('dto');

        $result = $this->registrationAndAuthorizationService->register(
            $dto->user_name,
            $dto->user_login,
            $dto->user_password
        );

        return $this->json($response, [
            'is_user_registered' => $result->registered,
            'token' => $result->token
        ]);
    }

    private function json(Response $res, mixed $payload, int $status = 200): Response
    {
        $response = $res->withStatus($status);
        $response->getBody()->write(json_encode($payload, JSON_UNESCAPED_UNICODE));
        return $response->withHeader('Content-Type', 'application/json');
    }

}