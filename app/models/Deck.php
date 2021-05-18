<?php

namespace App\Models;

use Core\Model;
use PDO;

class Deck extends Model
{
    private int $userId;

    private string $title;
    private string $description;

    public function __construct(int $userId, string $title, string $description, int $id = 0)
    {
        parent::__construct($id);

        $this->setUserId($userId);
        $this->setTitle($title);
        $this->setDescription($description);
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = self::validateId($userId);
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public static function findAllByUser(int $userId): array
    {
        $connection = self::getConnection();

        $statement = $connection->prepare(
            '
            SELECT `deck_id`, `user_id`, `title`, `description`
            FROM `deck`
            WHERE `user_id` = :userId;
            '
        );

        $statement->bindValue(':userId', $userId, PDO::PARAM_INT);

        $statement->execute();

        return array_map(
            fn ($result) => new Deck($result['user_id'], $result['title'], $result['description'], $result['deck_id']),
            $statement->fetchAll()
        );
    }
}
