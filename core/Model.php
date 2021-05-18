<?php

namespace Core;

use PDO;
use App\Configuration;

abstract class Model
{
    private int $id;

    public function __construct(int $id = 0)
    {
        $this->setId($id);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = self::validateId($id);
    }

    protected static function validateId(int $id): int
    {
        assert($id >= 0);
        return $id;
    }

    protected static function getConnection(): PDO
    {
        static $connection = null;

        if (!$connection) {
            $dbms = Configuration::DATABASE_DBMS;
            $host = Configuration::DATABASE_HOST;
            $database = Configuration::DATABASE_NAME;

            $user = Configuration::DATABASE_USER;
            $password = Configuration::DATABASE_PASSWORD;

            $connection = new PDO("$dbms:host=$host;dbname=$database", $user, $password);
        }

        return $connection;
    }
}
