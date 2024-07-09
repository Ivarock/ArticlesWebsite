<?php

namespace ArticlesWebsite\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerInterface;
use ArticlesWebsite\Services\TemplateRenderer;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class HomeController
{
    private LoggerInterface $logger;
    private TemplateRenderer $renderer;

    public function __construct(LoggerInterface $logger, TemplateRenderer $renderer)
    {
        $this->logger = $logger;
        $this->renderer = $renderer;
    }

    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public function index(Request $request, Response $response): Response
    {
        $this->logger->info('Home page accessed');
        return $this->renderer->render($response, 'home/index.twig');
    }
}
