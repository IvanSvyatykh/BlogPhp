<?php

namespace Pri301\Blog\DTO;
use Pri301\Blog\Enum\UserAuthState;

class LoginUserResponse
{
    public function __construct(
        public UserAuthState $userAuthorizedState,
        public string        $token
    ){}
}