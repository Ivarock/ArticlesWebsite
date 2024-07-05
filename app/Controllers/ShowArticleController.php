<?php

namespace ArticlesWebsite\Controllers;

use ArticlesWebsite\Repositories\ArticleRepositoryInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use ArticlesWebsite\Services\TemplateRenderer;

class ShowArticleController
{
    private ArticleRepositoryInterface $articleRepository;
    private TemplateRenderer $renderer;

    public function __construct(ArticleRepositoryInterface $articleRepository, TemplateRenderer $renderer)
    {
        $this->articleRepository = $articleRepository;
        $this->renderer = $renderer;
    }

    public function show(Request $request, Response $response, array $args): Response
    {
        $id = (int)$args['id'];
        $article = $this->articleRepository->find($id);
        return $this->renderer->render($response, 'articles/show.twig', ['article' => $article]);
    }
}
