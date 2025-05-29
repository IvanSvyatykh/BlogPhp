<?php

namespace Pri301\Blog\Infrastructure\Middlewares;

use Psr\Http\Server\MiddlewareInterface;
use Slim\Psr7\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class BaseValidationMiddleware implements MiddlewareInterface
{
    protected ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    protected function error(array $errors, int $status = 422): Response
    {
        $response = new Response($status);
        $response->getBody()->write(json_encode([
            'success' => false,
            'errors' => $errors
        ]));
        return $response->withHeader('Content-Type', 'application/json');
    }

    /** @return array<string,string> */
    protected function violationsToArray(iterable $violations): array
    {
        $errs = [];
        foreach ($violations as $v) {
            $errs[$v->getPropertyPath()] = $v->getMessage();
        }
        return $errs;
    }
}
