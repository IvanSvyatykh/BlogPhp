<?php


namespace Pri301\Blog\Application\Handlers;


use Pri301\Blog\Domain\Enum\UserAuthState;
use Pri301\Blog\Domain\Services\PostServiceInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


final class CreatePostHandler
{
    public function __construct(
        private PostServiceInterface $postService,
    ){}

    public function __invoke(Request $request, Response $response): Response
    {
        $dto = $request->getAttribute('dto');

        $post = $this->postService->createPost($dto);

        return

    }
}