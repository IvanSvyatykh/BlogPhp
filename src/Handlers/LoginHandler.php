<?php

namespace Pri301\Blog\Handlers;

use Pri301\Blog\DTO\LoginUserRequest;
use Pri301\Blog\Services\RegistrationAndAuthorizationService;
use Pri301\Blog\Validator\DtoValidator;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


final class LoginHandler
{
    public function __construct(
        private RegistrationAndAuthorizationService $registrationAndAuthorizationService,
        private DtoValidator                        $validator
    ){}

    public function __invoke(Request $request, Response $response): Response
    {
        $data = (array)$request->getParsedBody();
        $dto = new LoginUserRequest();
        $dto->user_login = $data['user_login'] ?? '';
        $dto->user_password = $data['user_password'] ?? '';

        $errors = $this->validator->validate($dto);

        if (!empty($errors)) {
            $response->getBody()->write(json_encode(['errors' => $errors]));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }

        $result = $this->registrationAndAuthorizationService->login($dto->user_login, $dto->user_password);

        $response->getBody()->write(json_encode([
            'user_authorized_state' => $result->userAuthorizedState,
            'token' => $result->token
        ]));
        return $response->withHeader('Content-Type', 'application/json');
    }
}