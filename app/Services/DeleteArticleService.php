<?php

namespace ArticlesWebsite\Services;

use ArticlesWebsite\Repositories\ArticleRepositoryInterface;

class DeleteArticleService
{
    private ArticleRepositoryInterface $articleRepository;

    public function __construct(ArticleRepositoryInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function delete(int $id): void
    {
        $this->articleRepository->delete($id);
    }
}