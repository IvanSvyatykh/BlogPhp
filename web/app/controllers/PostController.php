<?php

namespace app\controllers;

use App\Models\Post;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

class PostController
{
    protected $view;
    protected $postModel;

    public function __construct(Twig $view, $db)
    {
        $this->view = $view;
        $this->postModel = new Post($db);
    }

    public function index(Request $request, Response $response)
    {
        $posts = $this->postModel->getAll();
        return $this->view->render($response, 'posts/index.twig', [
            'posts' => $posts
        ]);
    }

    public function show(Request $request, Response $response, $args)
    {
        $post = $this->postModel->getById($args['id']);
        return $this->view->render($response, 'posts/show.twig', [
            'post' => $post
        ]);
    }

    public function create(Request $request, Response $response)
    {
        return $this->view->render($response, 'posts/create.twig');
    }

    public function store(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        $this->postModel->create($data['title'], $data['content']);

        return $response
            ->withHeader('Location', '/')
            ->withStatus(302);
    }
}