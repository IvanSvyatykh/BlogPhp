<?php

namespace Pri301\Blog\Application\Handlers;

use Pri301\Blog\Application\DTO\Response\ArticleResponse;
use Pri301\Blog\Domain\Services\LikeServiceInterface;
use Pri301\Blog\Domain\Services\PostServiceInterface;
use Pri301\Blog\Domain\Services\PostTagsServiceInterface;
use Pri301\Blog\Domain\Services\TypeServiceInterface;
use Pri301\Blog\Domain\Services\UserServiceInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class GetAllUnpublishedHandler
{
    public function __construct(
        private readonly PostServiceInterface $postService,
        private readonly LikeServiceInterface $likeService,
        private readonly PostTagsServiceInterface $postTagsService,
        private readonly UserServiceInterface $userService
    ) {}

    public function __invoke(Request $request, Response $response): Response
    {
        $posts = $this->postService->getAllUnpublishedPosts();
        $result = array();
        foreach ($posts as $post)
        {
            $author = $post->getAuthor();
            $article = new ArticleResponse(
                article_id: $post->getId(),
                article_title: $post->getTitle(),
                article_text: $post->getContent(),
                author_login: $author->getLogin(),
                author_name: $author->getName(),
                article_likes_count:  $this->likeService->countLikes($post->getId()),
                article_category: "",
                article_tags: $this->postTagsService->getTagsByPostId($post->getId()),
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
}