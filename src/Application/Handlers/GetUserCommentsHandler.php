<?php

namespace Pri301\Blog\Application\Handlers;

use Pri301\Blog\Application\DTO\Requests\GetCommentsByPostIdRequest;
use Pri301\Blog\Domain\Services\CommentServiceInterface;
use Pri301\Blog\Domain\Services\UserServiceInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class GetUserCommentsHandler
{
    public function __construct(
        private readonly CommentServiceInterface $commentService,
        private readonly UserServiceInterface $userService,
    )
    {
    }

//    public function getCommentByPostId(Request $request, Response $response)
//    {
//        $data = (array)$request->getParsedBody();
//        $dto = new GetCommentsByPostIdRequest();
//        $dto->postId = $data['postId'];
//        $errors = $this->dtoValidator->validate($dto);
//        if (count($errors) > 0) {
//            $response->getBody()->write(json_encode(['errors' => $errors]));
//            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
//        }
//
//        $result = $this->commentService->getCommentsForPost($dto->postId);
//        $response->getBody()->write(json_encode($result));
//        return $response
//            ->withStatus(200)
//            ->withHeader('Content-Type', 'application/json');
//    }

    public function __invoke(Request $request, Response $response): Response
    {
        $dto = $request->getAttribute('dto');

        $login = $dto->userLogin;
        $user  = $this->userService->GetUserById($login);

        if (!$user) {
            return $this->errorResponse('Author not found', 404);
        }

        $comments = $this->commentService->getCommentsByUser($user);
        return $this->json($response, $comments);
    }

    private function json(Response $res, mixed $payload, int $status = 200): Response
    {
        $response = $res->withStatus($status);
        $response->getBody()->write(json_encode($payload, JSON_UNESCAPED_UNICODE));
        return $response->withHeader('Content-Type', 'application/json');
    }
}