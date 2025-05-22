<?php

use DI\Container;
use Doctrine\ORM\EntityManager;
use Pri301\Blog\Domain\Repository\LikeRepositoryInterface;
use Pri301\Blog\Domain\Repository\CommentRepositoryInterface;
use Pri301\Blog\Domain\Repository\PostRepositoryInterface;
use Pri301\Blog\Domain\Repository\StatusRepositoryInterface;
use Pri301\Blog\Domain\Repository\TagRepositoryInterface;
use Pri301\Blog\Domain\Repository\TypeRepositoryInterface;
use Pri301\Blog\Domain\Repository\UserRepositoryInterface;
use Pri301\Blog\Domain\Services\CommentService;
use Pri301\Blog\Domain\Services\CommentServiceInterface;
use Pri301\Blog\Domain\Services\LikeService;
use Pri301\Blog\Domain\Services\LikeServiceInterface;
use Pri301\Blog\Domain\Services\PostService;
use Pri301\Blog\Domain\Services\PostServiceInterface;
use Pri301\Blog\Domain\Services\UserService;
use Pri301\Blog\Domain\Services\UserServiceInterface;
use Pri301\Blog\Infarastructure\Doctrine\Repositories\LikeRepository;
use Pri301\Blog\Infarastructure\Doctrine\Repositories\CommentRepository;
use Pri301\Blog\Infarastructure\Doctrine\Repositories\PostRepository;
use Pri301\Blog\Infarastructure\Doctrine\Repositories\StatusRepository;
use Pri301\Blog\Infarastructure\Doctrine\Repositories\TagRepository;
use Pri301\Blog\Infarastructure\Doctrine\Repositories\TypeRepository;
use Pri301\Blog\Infarastructure\Doctrine\Repositories\UserRepository;
use Pri301\Blog\Domain\Services\RegistrationAndAuthorizationServiceInterface;
use Pri301\Blog\Domain\Services\RegistrationAndAuthorizationAndAuthorizationService;
require dirname(__DIR__) . '/vendor/autoload.php';

return function (Container $container) {
    $entityManager = require __DIR__ . '/bootstrap.php';
    $container->set(EntityManager::class, $entityManager);
    $container->set(CommentRepositoryInterface::class, function (Container $c) {
        return new CommentRepository($c->get(EntityManager::class));
    });
    $container->set(LikeRepositoryInterface::class, function (Container $c) {
        return new LikeRepository($c->get(EntityManager::class));
    });
    $container->set(PostRepositoryInterface::class, function (Container $c) {
        return new PostRepository($c->get(EntityManager::class));
    });
    $container->set(StatusRepositoryInterface::class, function (Container $c) {
        return new StatusRepository($c->get(EntityManager::class));
    });
    $container->set(TagRepositoryInterface::class, function (Container $c) {
        return new TagRepository($c->get(EntityManager::class));
    });
    $container->set(TypeRepositoryInterface::class, function (Container $c) {
        return new TypeRepository($c->get(EntityManager::class));
    });
    $container->set(UserRepositoryInterface::class, function (Container $c) {
        return new UserRepository($c->get(EntityManager::class));
    });
    $container -> set(CommentServiceInterface::class, function (Container $c) {
       return new CommentService($c->get(CommentRepositoryInterface::class),$c->get(EntityManager::class));
    });
    $container->set(LikeServiceInterface::class, function (Container $c) {
        return new LikeService($c->get(LikeRepositoryInterface::class),$c->get(EntityManager::class));
    });
    $container->set(PostServiceInterface::class, function (Container $c) {
        return new PostService($c->get(PostRepositoryInterface::class),$c->get(EntityManager::class),$c->get(StatusRepositoryInterface::class));
    });
    $container->set(RegistrationAndAuthorizationServiceInterface::class, function (Container $c) {
        return new RegistrationAndAuthorizationAndAuthorizationService($c->get(UserRepositoryInterface::class));
    });
    $container->set(UserServiceInterface::class, function (Container $c) {
        return new UserService($c->get(UserRepositoryInterface::class));
    });

};