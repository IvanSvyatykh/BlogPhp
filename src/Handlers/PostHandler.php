<?php
namespace Pri301\Blog\Handlers;

use Pri301\Blog\DTO\ArticleResponse;
use Pri301\Blog\DTO\GetPostsByUserRequest;
use Pri301\Blog\DTO\PublishPostRequest;
use Pri301\Blog\Repositories\UserRepository;
use Pri301\Blog\Services\PostService;
use Pri301\Blog\Validator\DtoValidator;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


final class PostHandler
{
    public function __construct(
        private readonly PostService $postService,
        private readonly UserRepository $userRepository,
        private readonly DtoValidator $validator
    ) {}

    public function getPostsBySubstr(Request $request, Response $response): Response
    {
        $dto = $request->getAttribute('dto');

        $substring = $dto->substring;
        $articlePart = $dto->articlePart;

        // TODO: использовать postService для настоящего поиска
        $result = [
            'substring' => $substring,
            'articlePart' => $articlePart,
            'posts' => ["Test"]
        ];

        $response->getBody()->write(json_encode($result));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function publishPost(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();
        $dto = new PublishPostRequest();
        $dto->name = $data['name'] ?? '';
        $dto->content = $data['content'] ?? '';
        $dto->author_login = $data['author_login'] ?? '';

        $errors = $this->validator->validate($dto);
        if (!empty($errors)) {
            $response->getBody()->write(json_encode(['errors' => $errors]));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }

        $user = $this->userRepository->findByLogin($dto->author_login);
        if (!$user) {
            $response->getBody()->write(json_encode(['error' => 'User not found']));
            return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
        }

        $post = $this->postService->createPost([
            'title' => $dto->name,
            'content' => $dto->content,
        ], $user->getId());

        $this->postService->publishPost($post->getId());

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

    public function getUnpublishedPosts(Request $request, Response $response): Response
    {
        return $this->respondWithPosts($request, $response, false);
    }

    private function respondWithPosts(Request $request, Response $response, bool $published): Response
    {
        $dto = new GetPostsByUserRequest();
        $dto->user_login = $request->getQueryParams()['user_login'] ?? '';

        $errors = $this->validator->validate($dto);
        if (!empty($errors)) {
            $response->getBody()->write(json_encode(['errors' => $errors]));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }

        $user = $this->userRepository->findByLogin($dto->user_login);
        if (!$user) {
            $response->getBody()->write(json_encode(['error' => 'User not found']));
            return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
        }

        $posts = $published
            ? $this->postService->getPublishedPostsByUser($user->getId())
            : $this->postService->getUnpublishedPostsByUser($user->getId());

        $result = array_map(
            fn($post) => new ArticleResponse(
                $post->getId(),
                $post->getTitle(),
                $post->getContent(),
                $post->getAuthor()?->getLogin(),
                $post->getAuthor()?->getUsername(),
                $published ? 0 : 0 //TODO: сделать получение лайков
            ),
            $posts
        );

        $response->getBody()->write(json_encode($result));
        return $response->withHeader('Content-Type', 'application/json');
    }
}