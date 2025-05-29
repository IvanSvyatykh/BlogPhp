<?php

namespace Pri301\Blog\Application\Handlers;

use Pri301\Blog\Domain\Services\PostServiceInterface;
use Pri301\Blog\Domain\Services\UserServiceInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Psr7\Response;

final class DeletePostHandler
{
    public function __construct(
        private readonly PostServiceInterface $postService,
        private readonly UserServiceInterface $userService,
    ) {
    }

    public function __invoke(Request $request, Response $response): Response
    {
        $dto = $request->getAttribute('dto');
        $userLogin = $dto->userLogin;
        $postId = $dto->articleId;

        $user = $this->userService->getUserByLogin($userLogin);

        if (!$user) {
            return $this->errorResponse('Author not found', 404);
        }

        $post = $this->postService->getPost($postId);
        if (!$post) {
            return $this->errorResponse('Post not found', 404);
        }

        if ($post->getAuthor()->getId() !== $user->getId() &&
            !$user->IsAdmin() && !$user->IsModerator()) {
            return $this->errorResponse('Forbidden', 403);
        }

        $this->postService->rejectPost($postId);
        return $response->withStatus(204);
    }

    private function errorResponse(string $msg, int $code): Response
    {
        $response = new Response($code);
        $response->getBody()->write(json_encode(['error' => ['message' => $msg]]));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
