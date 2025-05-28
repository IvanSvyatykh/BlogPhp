<?php

namespace Pri301\Blog\Application\Handlers;

use Pri301\Blog\Domain\Services\CommentServiceInterface;
use Pri301\Blog\Domain\Services\UserServiceInterface;
use Pri301\Blog\Infrastructure\Doctrine\Repositories\CommentRepository;
use Pri301\Blog\Infrastructure\Doctrine\Repositories\UserRepository;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class CreateCommentHandler
{
    public function __construct(
        private CommentServiceInterface $commentService,
        private readonly UserServiceInterface $userService,
    ){}

    public function __invoke(Request $request, Response $response): Response
    {
        $dto = $request->getAttribute("dto");
        $user = $this->userService->GetUserById($dto->userLogin);
        if (!$user) {
            return $this->json($response, ["error" => ["message" => "User not found"]], 404);
        }

        $comment = $this->commentService->addComment($dto->comment, $dto->postId, $user->getId());

        return $this->json($response, ['comment_id' => $comment->getId()], 201);
    }

    private function json(Response $res, mixed $payload, int $status = 200): Response
    {
        $response = $res->withStatus($status);
        $response->getBody()->write(json_encode($payload, JSON_UNESCAPED_UNICODE));
        return $response->withHeader('Content-Type', 'application/json');
    }
}