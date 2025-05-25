<?php



namespace Pri301\Blog\Infarastructure\Middlewares;

use Pri301\Blog\Application\DTO\Requests\CreatePostRequest;
use Pri301\Blog\Application\DTO\Requests\GetUserCommentsRequest;
use Pri301\Blog\Infrastructure\Middlewares\BaseValidationMiddleware;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as Handler;
use Symfony\Component\Validator\Validation;

final class GetUserCommentsMiddleware extends BaseValidationMiddleware
{
    public function process(Request $request, Handler $handler): Response
    {
        $login = $request->getQueryParams()['user_login'] ?? '';

        $dto = new GetUserCommentsRequest();
        $dto->userLogin = $login;

        $violations = $this->validator->validate($dto);
        if (\count($violations) > 0) {
            return $this->error($this->violationsToArray($violations));
        }

        return $handler->handle($request->withAttribute('dto', $dto));
    }
}