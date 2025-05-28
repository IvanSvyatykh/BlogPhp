<?php


namespace Pri301\Blog\Application\Handlers;

use Pri301\Blog\Application\DTO\Response\ArticleResponse;
use Pri301\Blog\Domain\Services\LikeServiceInterface;
use Pri301\Blog\Domain\Services\PostServiceInterface;
use Pri301\Blog\Domain\Services\PostTagsServiceInterface;
use Pri301\Blog\Domain\Services\TypeServiceInterface;
use Pri301\Blog\Domain\Services\UserServiceInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Psr7\Response;

final class GetUnpublishedPostsHandler
{
    public function __construct(
        private readonly PostServiceInterface     $postService,
        private readonly UserServiceInterface     $userService,
        private readonly LikeServiceInterface     $likeService,
        private readonly TypeServiceInterface     $typeService,
        private readonly PostTagsServiceInterface $postTagsService,
    ){}

    public function __invoke(Request $request, Response $response): Response
    {
        $dto   = $request->getAttribute('dto');
        $login = $dto->userLogin;
        $user  = $this->userService->getUserByLogin($login);

        if (!$user) {
            return $this->errorResponse('Author not found' , 404);
        }

        $result = array();
        $posts = $this->postService->getUnpublishedPostsByUser($user->getId());
        foreach ($posts as $post)
        {
            $author = $this->userService->getUserById($post->getAuthor()->getId());
            $article = new ArticleResponse(
                article_id: $post->getId(),
                article_title: $post->getTitle(),
                article_text: $post->getContent(),
                author_login: $author->getLogin(),
                author_name: $author->getName(),
                article_category: $this->typeService->getTypeById($post->getType()->getId()),
                article_tags: $this->postTagsService->getTagsByPostId($post->getId()),
                article_likes_count: $this->likeService->countLikes($post->getId()),
            );
            $result[]=$article;
        }

        return $this->json($response, $result);
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