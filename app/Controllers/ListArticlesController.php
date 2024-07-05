<?php

namespace ArticlesWebsite\Controllers;

use ArticlesWebsite\Repositories\ArticleRepositoryInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use ArticlesWebsite\Services\TemplateRenderer;

class ListArticlesController
{
    private ArticleRepositoryInterface $articleRepository;
    private TemplateRenderer $renderer;

    public function __construct(ArticleRepositoryInterface $articleRepository, TemplateRenderer $renderer)
    {
        $this->articleRepository = $articleRepository;
        $this->renderer = $renderer;
    }

    public function list(Request $request, Response $response, array $args): Response
    {
        $articles = $this->articleRepository->findAll();
        return $this->renderer->render($response, 'articles/list.twig', ['articles' => $articles]);
    }
}
