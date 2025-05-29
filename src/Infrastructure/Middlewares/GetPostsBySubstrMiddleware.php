<?php


namespace Pri301\Blog\Infrastructure\Middlewares;

use Pri301\Blog\Application\DTO\Requests\GetPostsBySubstrRequest;
use Pri301\Blog\Domain\Enum\PostPart;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as Handler;
use Slim\Psr7\Response;
use Slim\Routing\RouteContext;
use function count;

final class GetPostsBySubstrMiddleware extends BaseValidationMiddleware
{
    public function process(Request $request, Handler $handler): Response
    {
        $body = (array)$request->getQueryParams();

        $routeContext = RouteContext::fromRequest($request);
        $route = $routeContext->getRoute();

        if ($route === null) {
            return $this->error(['message' => 'Route not resolved']);
        }


        $dto = new GetPostsBySubstrRequest();
        $dto->part = $body['part'] ?? '';
        $dto->substr = $body['substr'] ?? '';

        $violations = $this->validator->validate($dto);
        if (count($violations) > 0) {
            return $this->error($this->violationsToArray($violations));
        }

        return $handler->handle($request->withAttribute('dto', $dto));
    }
}