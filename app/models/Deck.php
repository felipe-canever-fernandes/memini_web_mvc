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

    public static function findById(int $id)
    {
        $connection = self::getConnection();

        $statement = $connection->prepare(
            '
            SELECT `deck_id`, `user_id`, `title`, `description`
            FROM `deck`
            WHERE `deck_id` = :id
            LIMIT 1;
            '
        );

        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        $result = $statement->fetch();

        if ($result === false)
            return false;

        return new Deck(
            $result['user_id'],
            $result['title'],
            $result['description'],
            $result['deck_id']
        );
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

    /**
     * @throws ValidationErrorException
     */
    public static function save(Deck $deck): void
    {
        $errors = self::validate($deck);

        if (!empty($errors))
            throw new ValidationErrorException(self::class, $errors);

        $connection = self::getConnection();

        $statement = $connection->prepare(
            '
            INSERT INTO `deck`
                (`user_id`, `title`, `description`)
            VALUES
                (:userId, :title, :description);
            '
        );

        $statement->bindValue(':userId',        $deck->getUserId(),         PDO::PARAM_INT);
        $statement->bindValue(':title',         $deck->getTitle(),          PDO::PARAM_STR);
        $statement->bindValue(':description',   $deck->getDescription(),    PDO::PARAM_STR);

        $statement->execute();
        $deck->setId($connection->lastInsertId());
    }

    /**
     * @throws ValidationErrorException
     */
    public static function update(Deck $deck): void
    {
        $errors = self::validate($deck, true);

        if (!empty($errors))
            throw new ValidationErrorException(self::class, $errors);

        $connection = self::getConnection();

        $statement = $connection->prepare(
            '
            UPDATE `deck`
            SET `title` = :title, `description` = :description
            WHERE `deck_id` = :id
            LIMIT 1;
            '
        );

        $statement->bindValue(':title',         $deck->getTitle(),          PDO::PARAM_STR);
        $statement->bindValue(':description',   $deck->getDescription(),    PDO::PARAM_STR);
        $statement->bindValue(':id',            $deck->getId(),             PDO::PARAM_INT);

        $statement->execute();
    }

    public static function validate(Deck $deck, bool $exceptSelf = false): array
    {
        $errors = [];

        if (self::deckExists($deck, $exceptSelf))
            $errors['title'][] = 'You already have a deck with this title.';

        return $errors;
    }

    public static function deckExists(Deck $deck, bool $exceptSelf = false): bool
    {
        $connection = self::getConnection();

        $except = $exceptSelf ? 'AND `deck_id` != :deckId' : '';

        $statement = $connection->prepare(
            "
            SELECT `deck_id`
            FROM `deck`
            WHERE `user_id` = :userId AND `title` = :title $except
            LIMIT 1;
            "
        );

        $statement->bindValue(':userId',    $deck->getUserId(), PDO::PARAM_INT);
        $statement->bindValue(':title',     $deck->getTitle(),  PDO::PARAM_STR);
        $statement->bindValue(':deckId',    $deck->getId(),     PDO::PARAM_INT);

        $statement->execute();

        return $statement->fetch() != false;
    }

    public static function delete(int $id)
    {
        $connection = self::getConnection();

        $statement = $connection->prepare(
            '
            DELETE FROM `deck`
            WHERE `deck_id` = :id;
            '
        );

        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();
    }
}
