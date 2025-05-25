<?php


namespace Pri301\Blog\Infarastructure\Middlewares;

use Pri301\Blog\Application\DTO\Requests\GetPostsRequest;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as Handler;
use Symfony\Component\Validator\Validation;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\SignatureInvalidException;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use DomainException;
use InvalidArgumentException;

use UnexpectedValueException;
class JWTMiddleware implements MiddlewareInterface
{

    private string $secretKey;
    private string $algorithm;

    public function __construct(string $secretKey, string $algorithm = 'HS256')
    {
        $this->secretKey = $secretKey;
        $this->algorithm = $algorithm;
    }

    public function process(Request $request, Handler $handler): Response
    {
        $authHeader = $request->getHeaderLine('Authorization');
        if (empty($authHeader)) {
            return $this->createErrorResponse('Authorization header is required', 401);
        }
        if (!preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            return $this->createErrorResponse('Invalid Authorization header format', 401);
        }
        $jwt = $matches[1];

        try {
            $decoded = JWT::decode($jwt, new Key($this->secretKey, $this->algorithm));
            $request = $request->withAttribute('token', $decoded);
            return $handler->handle($request);

        } catch (ExpiredException $e) {
            return $this->createErrorResponse('Token has expired', 401);
        } catch (SignatureInvalidException $e) {
            return $this->createErrorResponse('Invalid token signature', 401);
        } catch (BeforeValidException $e) {
            return $this->createErrorResponse('Token not yet valid', 401);
        } catch (DomainException | InvalidArgumentException | UnexpectedValueException $e) {
            return $this->createErrorResponse('Invalid token', 401);
        }
    }

    private function createErrorResponse(string $message, int $statusCode = 401): Response
    {
        $response = new \Slim\Psr7\Response();
        $response->getBody()->write(json_encode([
            'error' => [
                'message' => $message,
                'code' => $statusCode
            ]
        ]));

        return $response
            ->withStatus($statusCode)
            ->withHeader('Content-Type', 'application/json');
    }
}