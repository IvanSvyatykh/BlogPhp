<?php

namespace Pri301\Blog\Infrastructure\Middlewares;

use Pri301\Blog\Application\DTO\Requests\GetCommentsByPostIdRequest;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as Handler;

class GetPostCommentsMiddleware extends BaseValidationMiddleware
{
    public function process(Request $request, Handler $handler): Response
    {
        $data = $request->getParsedBody();

        $dto = new GetCommentsByPostIdRequest();
        $dto->postId = $data['article_id'] ?? '';

        $violations = $this->validator->validate($dto);
        if (\count($violations) > 0) {
            return $this->error($this->violationsToArray($violations));
        }

        return $handler->handle($request->withAttribute('dto', $dto));
    }
}