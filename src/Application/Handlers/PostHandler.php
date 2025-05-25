<?php
namespace Pri301\Blog\Application\Handlers;

use Pri301\Blog\Application\DTO\Requests\GetPostsByUserRequest;
use Pri301\Blog\Application\DTO\Requests\PublishPostRequest;
use Pri301\Blog\Application\DTO\Response\ArticleResponse;
use Pri301\Blog\Application\DTO\Validator\DtoValidator;
use Pri301\Blog\Domain\Services\PostServiceInterface;
use Pri301\Blog\Domain\Services\UserServiceInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


final class PostHandler
{
    public function __construct(
        private readonly PostServiceInterface $postService,
        private readonly UserServiceInterface $userService,
    ) {}

    public function publishPost(Request $request, Response $response): Response
    {
        $dto = $request->getAttribute('dto');
        $user = $this->userService->GetUserById($dto->authorLogin);
        if (!$user) {
            $response->getBody()->write(json_encode(['error' => 'User not found']));
            return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
        }

        $post = $this->postService->createPost([
            'title' => $dto->name,
            'content' => $dto->content,
            'type' => $dto->type,
        ], $user->getId());


        return $response->withStatus(201);
    }

    public function deletePost(Request $request, Response $response, array $args): Response
    {
        $this->postService->deletePost((int) $args['id']);
        return $response->withStatus(204);
    }

    public function getPublishedPosts(Request $request, Response $response): Response
    {
        return $this->respondWithPosts($request, $response, true);
    }


}