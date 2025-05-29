<?php


namespace Pri301\Blog\Infrastructure\Middlewares;

use Pri301\Blog\Application\DTO\Requests\CreatePostRequest;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as Handler;
use Symfony\Component\Validator\Validation;

final class CreatePostMiddleware extends BaseValidationMiddleware
{
    public function process(Request $request, Handler $handler): Response
    {
        $data = $request->getParsedBody();

        $dto = new CreatePostRequest();
        $dto->title = $data['title'] ?? '';
        $dto->content = $data['content'] ?? '';
        $dto->authorLogin = $data['authorLogin'] ?? '';
        $dto->postTags = $data['postTags'] ?? '';

        $violations = $this->validator->validate($dto);

        if (count($violations) > 0) {
            return $this->error($this->violationsToArray($violations));
        }

        return $handler->handle(
            $request->withAttribute('dto', $dto),
        );
    }
}