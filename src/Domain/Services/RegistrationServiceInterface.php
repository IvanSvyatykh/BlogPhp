<?php
namespace Pri301\Blog\Domain\Services;


use Pri301\Blog\Application\DTO\Response\RegisterUserResponse;

interface RegistrationServiceInterface{


    public function register(string $username, string $login, string $password): RegisterUserResponse;

}