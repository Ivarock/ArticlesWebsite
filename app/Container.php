<?php

use ArticlesWebsite\Database;
use ArticlesWebsite\Repositories\ArticleRepository;
use ArticlesWebsite\Repositories\ArticleRepositoryInterface;
use ArticlesWebsite\Services\CreateArticleService;
use ArticlesWebsite\Services\EditArticleService;
use ArticlesWebsite\Services\DeleteArticleService;
use ArticlesWebsite\Services\TemplateRenderer;
use Doctrine\DBAL\Connection;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Psr\Log\LoggerInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use ArticlesWebsite\Controllers\ListArticlesController;
use ArticlesWebsite\Controllers\ShowArticleController;
use ArticlesWebsite\Controllers\CreateArticleController;
use ArticlesWebsite\Controllers\EditArticleController;
use ArticlesWebsite\Controllers\DeleteArticleController;

return [
    Connection::class => function () {
        return Database::getConnection();
    },
    ArticleRepositoryInterface::class => DI\autowire(ArticleRepository::class),
    CreateArticleService::class => DI\autowire(),
    EditArticleService::class => DI\autowire(),
    DeleteArticleService::class => DI\autowire(),
    LoggerInterface::class => function () {
        $logger = new Logger('app');
        $logger->pushHandler(new StreamHandler(__DIR__ . '/../storage/app.log', Logger::DEBUG));
        return $logger;
    },
    Environment::class => function () {
        $loader = new FilesystemLoader(__DIR__ . '/../Templates');
        return new Environment($loader);
    },
    TemplateRenderer::class => DI\autowire(),
    ListArticlesController::class => DI\autowire(),
    ShowArticleController::class => DI\autowire(),
    CreateArticleController::class => DI\autowire(),
    EditArticleController::class => DI\autowire(),
    DeleteArticleController::class => DI\autowire(),
];
