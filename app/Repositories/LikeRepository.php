<?php

namespace ArticlesWebsite\Repositories;

use ArticlesWebsite\Models\Like;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

class LikeRepository
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @throws Exception
     */
    public function findByItemIdAndType(int $itemId, string $itemType): int
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder->select('COUNT(*) as like_count')->from('likes')->where('item_id = :item_id')->andWhere('item_type = :item_type');
        $queryBuilder->setParameter('item_id', $itemId);
        $queryBuilder->setParameter('item_type', $itemType);
        $result = $queryBuilder->executeQuery()->fetchAssociative();

        return $result['like_count'];
    }

    /**
     * @throws Exception
     */
    public function save(Like $like): void
    {
        $this->connection->insert('likes', [
            'item_id' => $like->getItemId(),
            'item_type' => $like->getItemType(),
            'created_at' => $like->getCreatedAt()->format('Y-m-d H:i:s')
        ]);

        $like->setId((int)$this->connection->lastInsertId());
    }
}
