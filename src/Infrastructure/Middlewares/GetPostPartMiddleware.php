<?php

namespace Pri301\Blog\Infrastructure\Middlewares;

use Pri301\Blog\Application\DTO\Requests\GetPostsRequest;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as Handler;
use Symfony\Component\Validator\Validation;

class GetPostPartMiddleware implements MiddlewareInterface
{
    public function process(Request $request, Handler $handler): Response
    {
        $data = $request->getQueryParams();

        $dto = new GetPostsRequest();
        $dto->substring = $data['substring'] ?? $data;
        $dto->articlePart = $data['articlePart'] ?? '';

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

            $response = new \Slim\Psr7\Response();
            $response->getBody()->write(json_encode([
                'success' => false,
                'errors' => $errors
            ]));
            return $response->withStatus(422)->withHeader('Content-Type', 'application/json');
        }

        return $handler->handle(
            $request->withAttribute('dto', $dto)
        );
    }
}