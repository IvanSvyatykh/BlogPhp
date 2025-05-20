<?php

namespace Pri301\Blog\Application\Handlers;

use Pri301\Blog\Application\DTO\Requests\GetCommentsByPostIdRequest;
use Pri301\Blog\Domain\Services\CommentService;
use Pri301\Blog\Validator\DtoValidator;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CommentHandler
{
    public function __construct(
        private CommentService $commentService,
        private DtoValidator $dtoValidator
    ) {}

    public function getCommentByPostId(Request $request, Response $response)
    {
        $data = (array)$request->getParsedBody();
        $dto = new GetCommentsByPostIdRequest();
        $dto->postId = $data['postId'];
        $errors = $this->dtoValidator->validate($dto);
        if (count($errors) > 0) {
            $response->getBody()->write(json_encode(['errors' => $errors]));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }

        $result = $this->commentService->getCommentsForPost($dto->postId);
        $response->getBody()->write(json_encode($result));
        return $response
            ->withStatus(200)
            ->withHeader('Content-Type', 'application/json');
    }
}