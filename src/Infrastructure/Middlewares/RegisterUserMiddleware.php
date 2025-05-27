<?php


namespace Pri301\Blog\Infrastructure\Middlewares;

use Pri301\Blog\Application\DTO\Requests\RegisterUserRequest;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as Handler;
use Symfony\Component\Validator\Validation;

final class RegisterUserMiddleware extends BaseValidationMiddleware
{
    public function process(Request $request, Handler $handler): Response
    {
        $data = $request->getParsedBody();
        $dto = new RegisterUserRequest();

        $dto->user_name = $data['user_name'] ?? '';
        $dto->user_login = $data['user_login'] ?? '';
        $dto->user_password = $data['user_password'] ?? '';

        $violations = $this->validator->validate($dto);
        if (count($violations) > 0) {
            return $this->error($this->violationsToArray($violations));
        }

        return $handler->handle($request->withAttribute('dto', $dto));
    }
}