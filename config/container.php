<?php

use DI\Container;
use Doctrine\ORM\EntityManager;
use Pri301\Blog\Application\Handlers\CreatePostHandler;
use Doctrine\ORM\EntityManagerInterface;
use Pri301\Blog\Application\Handlers\DeletePostHandler;
use Pri301\Blog\Application\Handlers\GetPublishedPostsHandler;
use Pri301\Blog\Application\Handlers\GetUnpublishedPostsHandler;
use Pri301\Blog\Application\Handlers\ToggleLikeHandler;
use Pri301\Blog\Application\Handlers\CommentHandler;
use Pri301\Blog\Domain\Repository\PostTagsRepositoryInterface;
use Pri301\Blog\Application\Handlers\GetUserCommentsHandler;
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
use Pri301\Blog\Infrastructure\Doctrine\Repositories\PostTagsRepository;
use Pri301\Blog\Infrastructure\Middlewares\CreatePostMiddleware;
use Pri301\Blog\Infrastructure\Middlewares\JWTMiddleware;
use Pri301\Blog\Infrastructure\Doctrine\Repositories\LikeRepository;
use Pri301\Blog\Infrastructure\Doctrine\Repositories\CommentRepository;
use Pri301\Blog\Infrastructure\Doctrine\Repositories\PostRepository;
use Pri301\Blog\Infrastructure\Doctrine\Repositories\StatusRepository;
use Pri301\Blog\Infrastructure\Doctrine\Repositories\TagRepository;
use Pri301\Blog\Infrastructure\Doctrine\Repositories\TypeRepository;
use Pri301\Blog\Infrastructure\Doctrine\Repositories\UserRepository;
use Pri301\Blog\Domain\Services\RegistrationAndAuthorizationServiceInterface;
use Pri301\Blog\Domain\Services\RegistrationAndAuthorizationAndAuthorizationService;
use \Pri301\Blog\Application\Handlers\RegisterHandler;
use \Pri301\Blog\Application\Handlers\LoginHandler;
use Pri301\Blog\Application\Handlers\UserHandler;
use Pri301\Blog\Infrastructure\Middlewares\DeletePostMiddleware;
use Pri301\Blog\Infrastructure\Middlewares\GetPublishedPostsMiddleware;
use Pri301\Blog\Infrastructure\Middlewares\GetUnpublishedPostsMiddleware;
use Pri301\Blog\Infrastructure\Middlewares\GetUserCommentsMiddleware;
use Pri301\Blog\Infrastructure\Middlewares\LoginUserMiddleware;
use Pri301\Blog\Infrastructure\Middlewares\RegisterUserMiddleware;
use Pri301\Blog\Infrastructure\Middlewares\ToggleLikeMiddleware;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Validation;

require dirname(__DIR__) . '/vendor/autoload.php';

return function (Container $container) {
    $entityManager = require __DIR__ . '/bootstrap.php';
    #Зависимости для Middleware
    $container->set(ValidatorInterface::class, function (Container $container) {
        return Validation::createValidatorBuilder()
            ->enableAttributeMapping()
            ->getValidator();
    });
    $container->set(LoginUserMiddleware::class, function (Container $container) {
        return new LoginUserMiddleware($container->get(ValidatorInterface::class));
    });
    $container->set(RegisterUserMiddleware::class, function ($container) {
        return new RegisterUserMiddleware($container->get(ValidatorInterface::class));
    });
    $container->set(JWTMiddleware::class, function ($container) {
        return new JWTMiddleware($_ENV['JWT_SECRET'], $_ENV["ALGORITHM"]);
    });
    $container->set(ToggleLikeMiddleware::class, fn() => new ToggleLikeMiddleware());
    $container->set(CreatePostMiddleware::class, fn() => new CreatePostMiddleware($container->get(ValidatorInterface::class)));
    $container->set(DeletePostMiddleware::class, function (Container $container) {
        return new DeletePostMiddleware($container->get(ValidatorInterface::class));
    });
    $container->set(GetPublishedPostsMiddleware::class, function (Container $container) {
        return new GetPublishedPostsMiddleware($container->get(ValidatorInterface::class));
    });
    $container->set(GetUnpublishedPostsMiddleware::class, function (Container $container) {
        return new GetUnpublishedPostsMiddleware($container->get(ValidatorInterface::class));
    });
    $container->set(GetUserCommentsMiddleware::class, function (Container $container) {
        return new GetUserCommentsMiddleware($container->get(ValidatorInterface::class));
    });
    #Зависимости для БД
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
    $container->set(PostTagsRepositoryInterface::class, function (Container $c) {
        return new PostTagsRepository($c->get(EntityManager::class));
    });
    # Сервисы
    $container->set(CommentServiceInterface::class, function (Container $c) {
        return new CommentService(
            $c->get(CommentRepositoryInterface::class),
            $c->get(EntityManager::class)
        );
    });
    $container->set(LikeServiceInterface::class, function (Container $c) {
        return new LikeService($c->get(LikeRepositoryInterface::class), $c->get(UserRepositoryInterface::class), $c->get(EntityManager::class));
    });
    $container->set(PostServiceInterface::class, function (Container $c) {
        return new PostService($c->get(PostRepositoryInterface::class), $c->get(EntityManager::class),
            $c->get(StatusRepositoryInterface::class),
            $c->get(TagRepositoryInterface::class),
            $c->get(PostTagsRepositoryInterface::class));
    });
    $container->set(RegistrationAndAuthorizationServiceInterface::class, function (Container $c) {
        return new RegistrationAndAuthorizationAndAuthorizationService($c->get(UserRepositoryInterface::class));
    });
    $container->set(UserServiceInterface::class, function (Container $c) {
        return new UserService($c->get(UserRepositoryInterface::class));
    });
    #Хендлеры
    $container->set(UserHandler::class, function (Container $c) {
        return new UserHandler($c->get(UserServiceInterface::class));
    });
    $container->set(RegisterHandler::class, function (Container $c) {
        return new RegisterHandler($c->get(RegistrationAndAuthorizationServiceInterface::class));
    });
    $container->set(LoginHandler::class, function (Container $c) {
        return new LoginHandler($c->get(RegistrationAndAuthorizationServiceInterface::class));
    });
    $container->set(ToggleLikeHandler::class, function (Container $c) {
        return new ToggleLikeHandler($c->get(LikeServiceInterface::class));
    });
    $container->set(CreatePostHandler::class, function (Container $c) {
        return new CreatePostHandler($c->get(PostServiceInterface::class), $c->get(UserServiceInterface::class));
    });
    $container->set(GetUserCommentsHandler::class, function (Container $c) {
        return new GetUserCommentsHandler($c->get(CommentServiceInterface::class), $c->get(UserServiceInterface::class));
    });

    $container->set(GetPublishedPostsHandler::class, function (Container $c) {
        return new GetPublishedPostsHandler($c->get(PostServiceInterface::class), $c->get(UserServiceInterface::class));
    });

    $container->set(GetUnpublishedPostsHandler::class, function (Container $c) {
        return new GetUnpublishedPostsHandler($c->get(PostServiceInterface::class), $c->get(UserServiceInterface::class));
    });

    $container->set(DeletePostHandler::class, function (Container $c) {
        return new DeletePostHandler($c->get(PostServiceInterface::class), $c->get(UserServiceInterface::class));
    });
};