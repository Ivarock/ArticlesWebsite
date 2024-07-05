<?php

namespace ArticlesWebsite\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerInterface;
use ArticlesWebsite\Services\TemplateRenderer;

class HomeController
{
    private LoggerInterface $logger;
    private TemplateRenderer $renderer;

    public function __construct(LoggerInterface $logger, TemplateRenderer $renderer)
    {
        $this->logger = $logger;
        $this->renderer = $renderer;
    }

    public function index(Request $request, Response $response): Response
    {
        $this->logger->info('Home page accessed');
        return $this->renderer->render($response, 'home/index.twig');
    }
}
