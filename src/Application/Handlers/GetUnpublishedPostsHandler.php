<?php


namespace Pri301\Blog\Application\Handlers;

use Pri301\Blog\Domain\Services\PostServiceInterface;
use Pri301\Blog\Domain\Services\UserServiceInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


final class GetUnpublishedPostsHandler
{
    public function __construct(
        private PostServiceInterface $postService,
        private readonly UserServiceInterface $userService,
    ){}

    public function __invoke(Request $request, Response $response): Response
    {
        $dto   = $request->getAttribute('dto');
        $login = $dto->userLogin;
        $user  = $this->userService->GetUserById($login);

        if (!$user) {
            return $this->errorResponse('Author not found', 404);
        }

        $posts = $this->postService->getUnpublishedPostsByUser($user->getId());
        return $this->json($response, $posts);
    }

    private function json(Response $res, mixed $payload, int $status = 200): Response
    {
        $response = $res->withStatus($status);
        $response->getBody()->write(json_encode($payload, JSON_UNESCAPED_UNICODE));
        return $response->withHeader('Content-Type', 'application/json');
    }
}