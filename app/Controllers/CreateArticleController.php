<?php

namespace ArticlesWebsite\Controllers;

use ArticlesWebsite\Services\CreateArticleService;
use Doctrine\DBAL\Exception;
use Psr\Log\LoggerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use ArticlesWebsite\Services\TemplateRenderer;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class CreateArticleController
{
    private CreateArticleService $createService;
    private LoggerInterface $logger;
    private TemplateRenderer $renderer;

    public function __construct(CreateArticleService $createService, LoggerInterface $logger, TemplateRenderer $renderer)
    {
        $this->createService = $createService;
        $this->logger = $logger;
        $this->renderer = $renderer;
    }

    /**
     * @throws Exception
     */
    public function create(Request $request, Response $response, array $args): Response
    {
        if ($request->getMethod() === 'GET') {
            try {
                return $this->renderer->render($response, 'articles/create.twig');
            } catch (LoaderError|RuntimeError|SyntaxError $e) {
            }
        }

        $data = $request->getParsedBody();
        $title = $data['title'] ?? '';
        $content = $data['content'] ?? '';

        $article = $this->createService->create($title, $content);
        $this->logger->info('Created a new article', ['title' => $title]);

        return $response->withHeader('Location', '/articles')->withStatus(302);
    }
}
