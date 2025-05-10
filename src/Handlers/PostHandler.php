<?php
namespace Pri301\Blog\Handlers;

use  Pri301\Blog\Services\PostService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


final class PostHandler
{

    #public function __construct(private PostService $postService) {}

    public function getPostsBySubstr(Request $request, Response $response)
    {
        $dto = $request->getAttribute('dto');

        $substring = $dto->substring;
        $articlePart = $dto->articlePart;

        $result = [
            'substring' => $substring,
            'articlePart' => $articlePart,
            'posts' => ["Test"]
        ];

        $response->getBody()->write(json_encode($result));
        return $response->withHeader('Content-Type', 'application/json');

    }

}