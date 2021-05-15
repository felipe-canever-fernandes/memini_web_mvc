<?php

namespace App\Models;

use \Core\Model;

class Post extends Model
{
    public static function getAll(): array
    {
        $connection = self::getConnection();

        $statement = $connection->query(
            'SELECT `post_id`, `title`, `content`
            FROM `post`
            ORDER BY `date_created`;'
        );

        return $statement->fetchAll();
    }
}
