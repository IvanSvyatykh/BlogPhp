<?php

namespace Pri301\Blog\Application\DTO\Response;

use Pri301\Blog\Domain\Enum\UserAuthState;

class LoginUserResponse
{
    public function __construct(
        public UserAuthState $userAuthorizedState,
        public string $token
    ) {
    }
}