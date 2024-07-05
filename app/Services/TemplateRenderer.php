<?php

namespace ArticlesWebsite\Services;

use Twig\Environment;
use Psr\Http\Message\ResponseInterface as Response;

class TemplateRenderer
{
    private Environment $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function render(Response $response, string $template, array $data = []): Response
    {
        $response->getBody()->write($this->twig->render($template, $data));
        return $response;
    }
}
