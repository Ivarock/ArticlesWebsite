<?php

namespace ArticlesWebsite\Repositories;

use ArticlesWebsite\Models\Article;

interface ArticleRepositoryInterface
{
    public function findAll(): array;

    public function find(int $id): ?Article;

    public function save(Article $article): void;

    public function delete(int $id): void;
}