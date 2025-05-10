<?php

namespace Pri301\Blog\DTO;
class RegisterUserResponse
{
    public function __construct(
        public bool   $registered,
        public string $token
    ){}
}