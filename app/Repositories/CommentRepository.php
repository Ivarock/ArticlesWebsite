<?php

namespace ArticlesWebsite\Repositories;

use ArticlesWebsite\Models\Comment;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use DateTime;

class CommentRepository
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @throws Exception
     */
    public function findByArticleId(int $articleId): array
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder->select('*')
            ->from('comments')
            ->where('article_id = :article_id')
            ->setParameter('article_id', $articleId);

        $result = $queryBuilder->executeQuery()->fetchAllAssociative();

        return array_map(function ($row) {
            return new Comment(
                $row['article_id'],
                $row['content'],
                $row['author'],
                $row['id']
            );
        }, $result);
    }

    /**
     * @throws Exception
     */
    public function save(Comment $comment): void
    {
        if ($comment->getId() === null) {
            $this->connection->insert('comments', [
                'article_id' => $comment->getArticleId(),
                'content' => $comment->getContent(),
                'author' => $comment->getAuthor(),
                'created_at' => $comment->getCreatedAt()->format('Y-m-d H:i:s'),
                'updated_at' => $comment->getUpdatedAt()->format('Y-m-d H:i:s')
            ]);

            $comment->setId((int)$this->connection->lastInsertId());
        } else {
            $this->connection->update('comments', [
                'content' => $comment->getContent(),
                'author' => $comment->getAuthor(),
                'updated_at' => $comment->getUpdatedAt()->format('Y-m-d H:i:s')
            ], ['id' => $comment->getId()]);
        }
    }

    /**
     * @throws Exception
     */
    public function delete(int $id): void
    {
        $this->connection->delete('comments', ['id' => $id]);
    }
}
