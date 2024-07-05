<?php

namespace ArticlesWebsite;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Exception;

class Database
{
    /**
     * @throws Exception
     */
    public static function getConnection(): Connection
    {
        $connection = DriverManager::getConnection([
            'driver' => 'pdo_sqlite',
            'path' => __DIR__ . '/../storage/database.sqlite',
        ]);

        self::initialize($connection);

        return $connection;
    }

    /**
     * @throws Exception
     */
    private static function initialize(Connection $connection): void
    {
        $sql = <<<SQL
CREATE TABLE IF NOT EXISTS articles (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL,
    content TEXT NOT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL
)
SQL;

        $connection->executeStatement($sql);
    }
}
