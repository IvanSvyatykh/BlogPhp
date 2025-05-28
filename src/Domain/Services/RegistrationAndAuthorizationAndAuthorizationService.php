<?php

namespace Pri301\Blog\Domain\Services;

use DateTimeImmutable;
use Firebase\JWT\JWT;
use Pri301\Blog\Application\DTO\Response\LoginUserResponse;
use Pri301\Blog\Application\DTO\Response\RegisterUserResponse;
use Pri301\Blog\Domain\Entity\User;
use Pri301\Blog\Domain\Enum\UserAuthState;
use Pri301\Blog\Domain\Repository\UserRepositoryInterface;


class RegistrationAndAuthorizationAndAuthorizationService implements RegistrationAndAuthorizationServiceInterface
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }


    public function register(string $username, string $login, string $password): RegisterUserResponse
    {
        $anotherUserWithThisLogin = $this->userRepository->findByLogin($login);
        if ($anotherUserWithThisLogin !== null) {
            return new RegisterUserResponse(false, '');
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $user = new User($username, $login, $hashedPassword);
        $this->userRepository->addUser($user);

        $token = $this->generateToken($user);
        return new RegisterUserResponse(true, $token);
    }

    public function login(string $email, string $password): LoginUserResponse
    {
        $user = $this->userRepository->findByLogin($email);

        if (!$user || !password_verify($password, $user->getPassword())) {
            return new LoginUserResponse(UserAuthState::USER_NOT_AUTHORIZED, '');
        }

        if ($user->isBanned()) {
            return new LoginUserResponse(UserAuthState::USER_BANNED, '');
        }

        $token = $this->generateToken($user);

        if ($user->isModerator()) {
            return new LoginUserResponse(UserAuthState::USER_AUTHORIZED_AS_MODERATOR, $token);
        }

        if ($user->isAdmin()) {
            return new LoginUserResponse(UserAuthState::USER_AUTHORIZED_AS_ADMIN, $token);
        }

        return new LoginUserResponse(UserAuthState::USER_AUTHORIZED, $token);
    }

    private function generateToken(User $user): string
    {
        $payload = [
            'sub' => $user->getId(),
            'email' => $user->getLogin(),
            'iat' => time(),
            'exp' => time() + 3600,
        ];

        return JWT::encode($payload, $_ENV['JWT_SECRET'], $_ENV["ALGORITHM"]);
    }
}