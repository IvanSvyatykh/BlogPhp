<?php
namespace Pri301\Blog\Application\Handlers;

use Pri301\Blog\Application\DTO\Requests\GetPostsByUserRequest;
use Pri301\Blog\Application\DTO\Requests\CreatePostRequest;
use Pri301\Blog\Application\DTO\Response\ArticleResponse;
use Pri301\Blog\Application\DTO\Validator\DtoValidator;
use Pri301\Blog\Domain\Entity\Post;
use Pri301\Blog\Domain\Enum\PostStatus;
use Pri301\Blog\Domain\Services\PostServiceInterface;
use Pri301\Blog\Domain\Services\UserServiceInterface;
use Slim\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class PostHandler
{
    public function __construct(
        private readonly PostServiceInterface $postService,
        private readonly UserServiceInterface $userService,
    ) {}

    public function getPublishedPosts(Request $req, Response $res): Response
    {
        $dto   = $req->getAttribute('dto');
        $login = $dto->userLogin;
        $user  = $this->userService->GetUserById($login);

        if (!$user) {
            return $this->errorResponse('Author not found', 404);
        }

        $posts = $this->postService->getPublishedPostsByUser($user->getId());

        return $this->json($res, $posts);
    }

    public function getUnpublishedPosts(Request $req, Response $res): Response
    {
        $dto   = $req->getAttribute('dto');
        $login = $dto->userLogin;
        $user  = $this->userService->GetUserById($login);

        if (!$user) {
            return $this->errorResponse('Author not found', 404);
        }

        $posts = $this->postService->getUnpublishedPostsByUser($user->getId());
        return $this->json($res, $posts);
    }

    public function deletePost(Request $req, Response $res, array $args): Response
    {
        $postId = (int)$args['id'];
        $dto    = $req->getAttribute('dto');
        $login  = $dto->userLogin;
        $user   = $this->userService->GetUserById($login);

        if (!$user) {
            return $this->errorResponse('User not found', 404);
        }

        $post = $this->postService->getPost($postId);
        if (!$post) {
            return $this->errorResponse('Post not found', 404);
        }

        if ($post->getAuthor()->getId() !== $user->getId()) {
            return $this->errorResponse('Forbidden', 403);
        }

        $this->postService->deletePost($postId);
        return $res->withStatus(204);
    }

    public function createPost(Request $req, Response $res): Response
    {
        $dto  = $req->getAttribute('dto');
        $user = $this->userService->GetUserById($dto->authorLogin);

        if (!$user) {
            return $this->errorResponse('Author not found', 404);
        }

        $post = $this->postService->createPost([
            'title' => $dto->name,
            'content' => $dto->content,
            'type' => $dto->type,
        ], $user->getId());

        return $this->json($res, ['article_id' => $post->getId()], 201);
    }

    private function json(Response $res, mixed $payload, int $status = 200): Response
    {
        $response = $res->withStatus($status);
        $response->getBody()->write(json_encode($payload, JSON_UNESCAPED_UNICODE));
        return $response->withHeader('Content-Type', 'application/json');
    }

    private function errorResponse(string $msg, int $code): Response
    {
        $response = new Response($code);
        $response->getBody()->write(json_encode(['error' => ['message' => $msg]]));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
