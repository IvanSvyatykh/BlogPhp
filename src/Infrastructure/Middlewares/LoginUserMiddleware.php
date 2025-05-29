<?php

namespace Pri301\Blog\Infrastructure\Middlewares;

use Pri301\Blog\Application\DTO\Requests\LoginUserRequest;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as Handler;
use Symfony\Component\Validator\Validation;

final class LoginUserMiddleware extends BaseValidationMiddleware
{
    public function process(Request $request, Handler $handler): Response
    {
        $data = $request->getParsedBody();
        $dto = new LoginUserRequest();

        $dto->user_login = $data['user_login'] ?? '';
        $dto->user_password = $data['user_password'] ?? '';

        $violations = $this->validator->validate($dto);

        if (count($violations) > 0) {
            return $this->error($this->violationsToArray($violations));
        }

        return $handler->handle(
            $request->withAttribute('dto', $dto)
        );
    }
}