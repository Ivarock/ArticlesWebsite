<?php

namespace ArticlesWebsite\Repositories;

use ArticlesWebsite\Models\Article;
use DateTime;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

class ArticleRepository implements ArticleRepositoryInterface
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @throws Exception
     * @throws \Exception
     */
    public function findAll(): array
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder->select('*')->from('articles')->orderBy('created_at', 'DESC');
        $result = $queryBuilder->executeQuery()->fetchAllAssociative();
        return array_map(function ($row) {
            return new Article(
                $row['id'],
                $row['title'],
                $row['content'],
                new DateTime($row['created_at']),
                new DateTime($row['updated_at'])
            );
        }, $result);
    }

    /**
     * @throws Exception
     * @throws \Exception
     */
    public function find(int $id): ?Article
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder->select('*')->from('articles')->where('id = :id');
        $queryBuilder->setParameter('id', $id);
        $row = $queryBuilder->executeQuery()->fetchAssociative();
        if ($row === false) {
            return null;
        }
        return new Article(
            $row['id'],
            $row['title'],
            $row['content'],
            new DateTime($row['created_at']),
            new DateTime($row['updated_at'])
        );
    }

    /**
     * @throws Exception
     */
    public function save(Article $article): void
    {
        if ($article->getId() === 0) {
            $this->connection->insert('articles', [
                'title' => $article->getTitle(),
                'content' => $article->getContent(),
                'created_at' => $article->getCreatedAt()->format('Y-m-d H:i:s'),
                'updated_at' => $article->getUpdatedAt()->format('Y-m-d H:i:s')
            ]);

            $article->setId((int)$this->connection->lastInsertId());
        } else {
            $this->connection->update('articles', [
                'title' => $article->getTitle(),
                'content' => $article->getContent(),
                'updated_at' => $article->getUpdatedAt()->format('Y-m-d H:i:s')
            ], ['id' => $article->getId()]);
        }
    }

    /**
     * @throws Exception
     */
    public function delete(int $id): void
    {
        $this->connection->delete('articles', ['id' => $id]);
    }
}
