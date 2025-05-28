<?php

namespace Pri301\Blog\Infrastructure\Middlewares;

use Pri301\Blog\Application\DTO\Requests\AdminPostRequest;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as Handler;
use Pri301\Blog\Domain\Services\UserServiceInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AdminMiddleware implements MiddlewareInterface
{

    public function __construct(private UserServiceInterface $userService) {}
    public function process(Request $request, Handler $handler): Response
    {
        $email = $this->extractEmailFromToken($request, $handler);

        if (!$email) {
            return $this->errorResponse('Unauthorized', 401);
        }

        $user = $this->userService->GetUserById($email);

        if (!$user || !$user->IsAdmin()) {
            return $this->errorResponse('Forbidden', 403);
        }

        return $handler->handle($request);
    }

    private function errorResponse(string $msg, int $code): ResponseInterface
    {
        $response = new \Slim\Psr7\Response();
        $response->getBody()->write(json_encode(['error' => ['message' => $msg]], JSON_UNESCAPED_UNICODE));
        return $response->withHeader('Content-Type', 'application/json');
    }

    private function extractEmailFromToken(Request $request, Handler $handler): ?string
    {
        $authHeader = $request->getHeaderLine('Authorization');
        if (empty($authHeader)) {
            $this->errorResponse('Authorization header is required', 401);
        }
        if (!preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $this->errorResponse('Invalid Authorization header format', 401);
        }
        $jwt = $matches[1];
        try {
            $decoded = JWT::decode($jwt, new Key($_ENV['JWT_SECRET'], $_ENV['ALGORITHM']));
            return $decoded->email ?? null;
        } catch (\Throwable $e) {
            return null;
        }

//        $request = $request->withAttribute('token', $decoded);
//        return $handler->handle($request);
    }
}