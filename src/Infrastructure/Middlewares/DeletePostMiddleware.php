<?php

namespace Pri301\Blog\Infrastructure\Middlewares;

use Pri301\Blog\Application\DTO\Requests\DeletePostRequest;
use Slim\Psr7\Response;
use function count;

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