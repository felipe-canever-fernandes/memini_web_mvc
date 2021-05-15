<?php

namespace Core;

use PDO;
use App\Configuration;

abstract class Model
{
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
