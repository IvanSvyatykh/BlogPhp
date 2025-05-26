<?php

namespace Pri301\Blog\Infrastructure\Middlewares;

use Pri301\Blog\Application\DTO\Requests\DeletePostRequest;
use function count;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as Handler;
use Psr\Http\Message\ResponseInterface as Response;

final class DeletePostMiddleware implements MiddlewareInterface
{
    public function process(Request $request, Handler $handler): Response
    {
        $body = (array)$request->getParsedBody();
        $pathId = (int)$request->getAttribute('route')->getArgument('id');

        $dto = new DeletePostRequest();
        $dto->articleId = $pathId;
        $dto->userLogin = $body['user_login'] ?? '';

        $validator = Validation::createValidatorBuilder()
            ->enableAttributeMapping()
            ->getValidator();

        $violations = $validator->validate($dto);
        if (count($violations) > 0) {
            $errors = [];
            foreach ($violations as $violation) {
                $field = $violation->getPropertyPath();
                $errors[$field] = $violation->getMessage();
            }

            $response = new Response();
            $response->getBody()->write(json_encode([
                'success' => false,
                'errors' => $errors
            ]));
            return $response->withStatus(422)->withHeader('Content-Type', 'application/json');
        }

        return $handler->handle($request->withAttribute('dto', $dto));
    }
}