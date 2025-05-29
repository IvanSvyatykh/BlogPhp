<?php


namespace Pri301\Blog\Application\Handlers;

use Pri301\Blog\Domain\Services\PostServiceInterface;
use Pri301\Blog\Domain\Services\UserServiceInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Psr7\Response;


final class CreatePostHandler
{
    public function __construct(
        private PostServiceInterface $postService,
        private readonly UserServiceInterface $userService,
    ) {
    }

    public function __invoke(Request $request, Response $response): Response
    {
        $dto = $request->getAttribute('dto');
        $user = $this->userService->getUserByLogin($dto->authorLogin);

        if (!$user) {
            return $this->errorResponse('Author not found', 404);
        }
        $post = $this->postService->createPost([
            'title' => $dto->title,
            'content' => $dto->content,
            'tags' => $dto->postTags,
        ], $user->getId());


        return $this->json($response, ['article_id' => $post->getId()], 201);
    }

    private function json(Response $res, mixed $payload, int $status = 200): Response
    {
        $response = $res->withStatus($status);
        $response->getBody()->write(json_encode($payload, JSON_UNESCAPED_UNICODE));
        return $response->withHeader('Content-Type', 'application/json');
    }

    private function errorResponse(string $msg, int $code): \Slim\Psr7\Response
    {
        $response = new Response($code);
        $response->getBody()->write(json_encode(['error' => ['message' => $msg]]));
        return $response->withHeader('Content-Type', 'application/json');
    }
}