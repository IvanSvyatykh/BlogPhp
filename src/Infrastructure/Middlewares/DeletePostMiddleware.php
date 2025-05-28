<?php

namespace Pri301\Blog\Infrastructure\Middlewares;

use Pri301\Blog\Application\DTO\Requests\DeletePostRequest;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as Handler;
use Slim\Psr7\Response;
use Slim\Routing\RouteContext;
use function count;

final class DeletePostMiddleware extends BaseValidationMiddleware
{
    public function process(Request $request, Handler $handler): Response
    {
        $body = (array)$request->getQueryParams();

        $routeContext = RouteContext::fromRequest($request);
        $route = $routeContext->getRoute();

        if ($route === null) {
            return $this->error(['message' => 'Route not resolved']);
        }

        $pathId = (int)$route->getArgument('id');

        $dto = new DeletePostRequest();
        $dto->articleId = $pathId;
        $dto->userLogin = $body['userLogin'] ?? '';

        $violations = $this->validator->validate($dto);
        if (count($violations) > 0) {
            return $this->error($this->violationsToArray($violations));
        }

        return $handler->handle($request->withAttribute('dto', $dto));
    }
}