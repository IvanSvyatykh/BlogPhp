<?php


namespace Pri301\Blog\Application\Handlers;

use Pri301\Blog\Application\DTO\Response\ArticleResponse;
use Pri301\Blog\Application\DTO\Response\ArticleResponseWithLikeState;
use Pri301\Blog\Domain\Enum\PostPart;
use Pri301\Blog\Domain\Repository\PostTagsRepositoryInterface;
use Pri301\Blog\Domain\Services\CommentServiceInterface;
use Pri301\Blog\Domain\Services\LikeServiceInterface;
use Pri301\Blog\Domain\Services\PostServiceInterface;
use Pri301\Blog\Domain\Services\PostTagsServiceInterface;
use Pri301\Blog\Domain\Services\TypeServiceInterface;
use Pri301\Blog\Domain\Services\UserServiceInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Psr7\Response;

use function DI\add;

final class GetPostsBySubstrForUserHandler
{
    public function __construct(
        private readonly PostServiceInterface $postService,
        private readonly UserServiceInterface $userService,
        private readonly LikeServiceInterface $likeService,
        private readonly TypeServiceInterface $typeService,
        private readonly PostTagsServiceInterface $postTagsService,
    ) {
    }

    public function __invoke(Request $request, Response $response): Response
    {
        $dto = $request->getAttribute('dto');
        $part = $dto->articlePart;
        $substr = $dto->substring;
        $userLogin = $dto->userLogin;
        $result = array();

        if ($part === PostPart::Author->value) {
            $users = $this->userService->getUserIdBySubstrAtName($substr);

            foreach ($users as $user) {
                $user_info = $this->userService->getUserById($user);

                $posts_by_user = $this->postService->getPublishedPostsByUser($user);

                foreach ($posts_by_user as $post) {
                    $article = new ArticleResponseWithLikeState(
                        article_id: $post->getId(),
                        article_title: $post->getTitle(),
                        article_text: $post->getContent(),
                        author_login: $user_info->getLogin(),
                        author_name: $user_info->getName(),
                        article_likes_count: $this->likeService->countLikes($post->getId()),
                        article_category: $this->typeService->getTypeById($post->getType()->getId()),
                        article_tags: $this->postTagsService->getTagsByPostId($post->getId()),
                        isLiked: $this->likeService->hasLike($post->getId(), $userLogin)
                    );
                    $result[] = $article;
                }
            }
        }

        if ($part === PostPart::Article_name->value) {
            $result = array();
            $posts = $this->postService->getPostsBySubstrAtTitle($substr);
            foreach ($posts as $post) {
                $author = $this->userService->getUserById($post->getAuthor()->getId());
                $article = new ArticleResponseWithLikeState(
                    article_id: $post->getId(),
                    article_title: $post->getTitle(),
                    article_text: $post->getContent(),
                    author_login: $author->getLogin(),
                    author_name: $author->getName(),
                    article_likes_count: $this->likeService->countLikes($post->getId()),
                    article_category: $this->typeService->getTypeById($post->getType()->getId()),
                    article_tags: $this->postTagsService->getTagsByPostId($post->getId()),
                    isLiked: $this->likeService->hasLike($post->getId(), $userLogin)
                );
                $result[] = $article;
            }
        }
        if ($part === PostPart::ArticleText->value) {
            $result = array();
            $posts = $this->postService->getPostsBySubstrAtContent($substr);
            foreach ($posts as $post) {
                $author = $this->userService->getUserById($post->getAuthor()->getId());

                $article = new ArticleResponseWithLikeState(
                    article_id: $post->getId(),
                    article_title: $post->getTitle(),
                    article_text: $post->getContent(),
                    author_login: $author->getLogin(),
                    author_name: $author->getName(),
                    article_likes_count: $this->likeService->countLikes($post->getId()),
                    article_category: $this->typeService->getTypeById($post->getType()->getId()),
                    article_tags: $this->postTagsService->getTagsByPostId($post->getId()),
                    isLiked: $this->likeService->hasLike($post->getId(), $userLogin)
                );
                $result[] = $article;
            }
        }
        if ($part === PostPart::Type->value) {
            $result = array();
            $posts = $this->postService->getPostsBySubstrAtType($substr);

            foreach ($posts as $post) {
                $author = $this->userService->getUserById($post->getAuthor()->getId());
                $article = new ArticleResponseWithLikeState(
                    article_id: $post->getId(),
                    article_title: $post->getTitle(),
                    article_text: $post->getContent(),
                    author_login: $author->getLogin(),
                    author_name: $author->getName(),
                    article_likes_count: $this->likeService->countLikes($post->getId()),
                    article_category: $this->typeService->getTypeById($post->getType()->getId()),
                    article_tags: $this->postTagsService->getTagsByPostId($post->getId()),
                    isLiked: $this->likeService->hasLike($post->getId(), $userLogin)
                );
                $result[] = $article;
            }
        }
        if ($part === PostPart::Tag->value) {
            $result = array();
            $postIds = $this->postService->getPostsBySubstrAtTag($substr);
            foreach ($postIds as $postId) {
                $post = $this->postService->getPost($postId['post_id']);
                if ($post->getStatus()->getId() != 1) {
                    continue;
                }
                if ($post->getType() === null) {
                    continue;
                }
                $author = $this->userService->getUserById($post->getAuthor()->getId());
                $article = new ArticleResponseWithLikeState(
                    article_id: $post->getId(),
                    article_title: $post->getTitle(),
                    article_text: $post->getContent(),
                    author_login: $author->getLogin(),
                    author_name: $author->getName(),
                    article_likes_count: $this->likeService->countLikes($post->getId()),
                    article_category: $this->typeService->getTypeById($post->getType()->getId()),
                    article_tags: $this->postTagsService->getTagsByPostId($post->getId()),
                    isLiked: $this->likeService->hasLike($post->getId(), $userLogin)
                );
                $result[] = $article;
            }
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