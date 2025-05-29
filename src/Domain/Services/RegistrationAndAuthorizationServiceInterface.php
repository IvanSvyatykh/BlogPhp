<?php

namespace Pri301\Blog\Domain\Services;


use Pri301\Blog\Application\DTO\Response\LoginUserResponse;
use Pri301\Blog\Application\DTO\Response\RegisterUserResponse;

interface RegistrationAndAuthorizationServiceInterface
{
    public function register(string $username, string $login, string $password): RegisterUserResponse;

    public function login(string $email, string $password): LoginUserResponse;

}