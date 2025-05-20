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
use Pri301\Blog\Infarastructure\Doctrine\Repositories\LikeRepository;
use Pri301\Blog\Infarastructure\Doctrine\Repositories\CommentRepository;
use Pri301\Blog\Infarastructure\Doctrine\Repositories\PostRepository;
use Pri301\Blog\Infarastructure\Doctrine\Repositories\StatusRepository;
use Pri301\Blog\Infarastructure\Doctrine\Repositories\TagRepository;
use Pri301\Blog\Infarastructure\Doctrine\Repositories\TypeRepository;
use Pri301\Blog\Infarastructure\Doctrine\Repositories\UserRepository;

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

};