<?php
namespace Pri301\Blog\Application\Handlers;

use Pri301\Blog\Domain\Services\UserServiceInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class GetUserNameByLoginHandler
{
    public function __construct(
        private UserServiceInterface $userService,
    ){}

    public function __invoke(Request $request, Response $response) : Response
    {
        $dto = $request->getAttribute("dto");
        $login = $dto->user_login;

        $user = $this->userService->getUserByLogin($login);
        if(!$user){
            return $this->json($response,["err"=>"No user with this email"],status: 404);
        }
        return $this->json($response, $user->getName());
    }

    private function json(Response $res, mixed $payload, int $status = 200): Response
    {
        $response = $res->withStatus($status);
        $response->getBody()->write(json_encode($payload, JSON_UNESCAPED_UNICODE));
        return $response->withHeader('Content-Type', 'application/json');
    }
}