<?php

namespace Pri301\Blog\Infrastructure\Middlewares;

use Pri301\Blog\Application\DTO\Requests\GetUnpublishedPostsRequest;
use Slim\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as Handler;

use function count;

final class GetUnpublishedPostsMiddleware extends BaseValidationMiddleware
{
    public function process(Request $request, Handler $handler): Response
    {
        $data = $request->getQueryParams();
        $dto = new GetUnpublishedPostsRequest();

        $dto->userLogin = $data['userLogin'] ?? '';

        $violations = $this->validator->validate($dto);
        if (count($violations) > 0) {
            return $this->error($this->violationsToArray($violations));
        }

        return $handler->handle($request->withAttribute('dto', $dto));
    }
}