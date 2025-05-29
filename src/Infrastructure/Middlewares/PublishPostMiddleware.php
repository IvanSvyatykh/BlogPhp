<?php

namespace Pri301\Blog\Infrastructure\Middlewares;

use Pri301\Blog\Application\DTO\Requests\PublishPostRequest;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as Handler;

class PublishPostMiddleware extends BaseValidationMiddleware
{
    public function process(Request $request, Handler $handler): Response
    {
        $data = $request->getParsedBody();

        $dto = new PublishPostRequest();
        $dto->postId = $data['article_id'] ?? '';
        $dto->categoryName = $data['category_name'] ?? '';

        $violations = $this->validator->validate($dto);

        if (count($violations) > 0) {
            return $this->error($this->violationsToArray($violations));
        }

        return $handler->handle(
            $request->withAttribute('dto', $dto),
        );
    }
}