<?php

namespace ArticlesWebsite\Services;

use ArticlesWebsite\Models\Article;
use ArticlesWebsite\Repositories\ArticleRepository;
use Doctrine\DBAL\Exception;

class CreateArticleService
{
    private ArticleRepository $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    /**
     * @throws Exception
     */
    public function create(
        string $title,
        string $content
    ): Article
    {
        $article = new Article(0, $title, $content);
        $this->articleRepository->save($article);
        return $article;
    }
}