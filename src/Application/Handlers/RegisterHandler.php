<?php

namespace Pri301\Blog\Application\Handlers;

use Pri301\Blog\Application\DTO\Requests\RegisterUserRequest;
use Pri301\Blog\Application\DTO\Validator\DtoValidator;
use Pri301\Blog\Domain\Services\RegistrationAndAuthorizationService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


final class RegisterHandler
{
    public function __construct(
        private RegistrationAndAuthorizationService $registrationAndAuthorizationService,
        private DtoValidator                        $validator
    ){}

    public function __invoke(Request $request, Response $response): Response
    {
        $data = (array)$request->getParsedBody();
        $dto = new RegisterUserRequest();
        $dto->user_name = $data['user_name'] ?? '';
        $dto->user_login = $data['user_login'] ?? '';
        $dto->user_password = $data['user_password'] ?? '';

        $errors = $this->validator->validate($dto);

        if (!empty($errors)) {
            $response->getBody()->write(json_encode(['errors' => $errors]));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }

        $result = $this->registrationAndAuthorizationService->register($dto->user_name, $dto->user_login, $dto->user_password);

        $response->getBody()->write(json_encode([
            'is_user_registered' => $result->registered,
            'token' => $result->token
        ]));
        return $response->withHeader('Content-Type', 'application/json');
    }
}