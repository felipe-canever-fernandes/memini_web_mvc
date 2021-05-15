<?php

namespace Core;

use \PDO;

abstract class Model
{
    protected static function getConnection(): PDO
    {
        static $connection = null;

        if (!$connection) {
            $dbms = 'mysql';
            $host = 'localhost';
            $database = 'mvc';

            $user = 'root';
            $password = '';

            $connection = new PDO("$dbms:host=$host;dbname=$database", $user, $password);
        }

        return $connection;
    }
}
