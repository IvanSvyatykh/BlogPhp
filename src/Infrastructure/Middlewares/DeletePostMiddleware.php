<?php

namespace Pri301\Blog\Infrastructure\Middlewares;

use Pri301\Blog\Application\DTO\Requests\DeletePostRequest;
use function count;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as Handler;
use Psr\Http\Message\ResponseInterface as Response;
final class DeletePostMiddleware extends BaseValidationMiddleware
{
    public function process(Request $request, Handler $handler): Response
    {
        $body = (array)$request->getParsedBody();
        $pathId = (int)$request->getAttribute('route')->getArgument('id');

        $dto = new DeletePostRequest();
        $dto->articleId = $pathId;
        $dto->userLogin = $body['user_login'] ?? '';

        $violations = $this->validator->validate($dto);
        if (count($violations) > 0) {
            return $this->error($this->violationsToArray($violations));
        }

        return $handler->handle($request->withAttribute('dto', $dto));
    }
}