<?php

namespace ArticlesWebsite\Controllers;

use ArticlesWebsite\Repositories\ArticleRepositoryInterface;
use ArticlesWebsite\Repositories\LikeRepository;
use Doctrine\DBAL\Exception;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use ArticlesWebsite\Services\TemplateRenderer;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class ListArticlesController
{
    private ArticleRepositoryInterface $articleRepository;
    private LikeRepository $likeRepository;
    private TemplateRenderer $renderer;

    public function __construct(
        ArticleRepositoryInterface $articleRepository,
        LikeRepository $likeRepository,
        TemplateRenderer $renderer
    ) {
        $this->articleRepository = $articleRepository;
        $this->likeRepository = $likeRepository;
        $this->renderer = $renderer;
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     * @throws Exception
     */
    public function list(Request $request, Response $response, array $args): Response
    {
        $articles = $this->articleRepository->findAll();

        foreach ($articles as $article) {
            $article->likes = $this->likeRepository->findByItemIdAndType($article->getId(), 'article');
        }

        return $this->renderer->render($response, 'articles/list.twig', ['articles' => $articles]);
    }
}
