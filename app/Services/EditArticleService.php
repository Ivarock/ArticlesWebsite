<?php

namespace ArticlesWebsite\Services;

use ArticlesWebsite\Models\Article;
use ArticlesWebsite\Repositories\ArticleRepositoryInterface;
use Exception;

class EditArticleService
{
    private ArticleRepositoryInterface $articleRepository;

    public function __construct(ArticleRepositoryInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    /**
     * @throws Exception
     */
    public function edit(
        int    $id,
        string $title,
        string $content
    ): Article
    {
        $article = $this->articleRepository->find($id);
        if ($article === null) {
            throw new Exception('Article not found');
        }
        $article->setTitle($title);
        $article->setContent($content);
        $this->articleRepository->save($article);
        return $article;
    }
}
