<?php
namespace Pri301\Blog\Domain\Services;



interface UserServiceInterface{


    public function switchBanUser(int $userId): void;
    public function getUsersList(): array;
}