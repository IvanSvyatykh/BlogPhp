<?php

namespace Pri301\Blog\Application\Handlers;

use Pri301\Blog\Application\DTO\Requests\RegisterUserRequest;
use Pri301\Blog\Application\DTO\Validator\DtoValidator;
use Pri301\Blog\Domain\Services\RegistrationAndAuthorizationAndAuthorizationService;
use Pri301\Blog\Domain\Services\RegistrationAndAuthorizationServiceInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


final class RegisterHandler
{
    public function __construct(
        private RegistrationAndAuthorizationServiceInterface $registrationAndAuthorizationService,
    ){}

    public function __invoke(Request $request, Response $response): Response
    {
        $dto = $request->getAttribute('dto');

        $result = $this->registrationAndAuthorizationService->register($dto->user_name, $dto->user_login, $dto->user_password);
        if (!$result->registered)
        {
            $response->getBody()->write(json_encode([
                'is_user_registered' => $result->registered,
                'token' => $result->token
            ]));
            return  $response->withHeader('Content-Type', 'application/json')->withStatus(409);
        }

        $response->getBody()->write(json_encode([
            'is_user_registered' => $result->registered,
            'token' => $result->token
        ]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}