<?php

namespace Pri301\Blog\Application\DTO\Response;

class RegisterUserResponse
{
    public function __construct(
        public bool $registered,
        public string $token
    ) {
    }
}