<?php

namespace Pri301\Blog\Infrastructure\Middlewares;

use Pri301\Blog\Application\DTO\Requests\CreateCommentRequest;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as Handler;

class CreateCommentMiddleware extends BaseValidationMiddleware
{
    public function process(Request $request, Handler $handler): Response
    {
        $data = $request->getParsedBody();

        $dto = new CreateCommentRequest();
        $dto->postId = $data['article_id'] ?? '';
        $dto->userLogin = $data['comment_author_login'] ?? '';
        $dto->comment = $data['comment_text'] ?? '';

        $violations = $this->validator->validate($dto);

        if (count($violations) > 0) {
            return $this->error($this->violationsToArray($violations));
        }

        return $handler->handle(
            $request->withAttribute('dto', $dto),
        );
    }
}