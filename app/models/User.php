<?php

namespace App\Models;

use Core\Model;

class User extends Model
{
    private int $id;
    private string $name;
    private string $email;
    private string $hashedPassword;

    public function __construct(string $name, string $email, string $hashedPassword, int $id = 0)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->hashedPassword = $hashedPassword;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getHashedPassword(): string
    {
        return $this->hashedPassword;
    }

    public function setHashedPassword(string $hashedPassword): void
    {
        $this->hashedPassword = $hashedPassword;
    }

    public static function insert(User $user): bool
    {
        $connection = self::getConnection();

        $statement = $connection->prepare(
            '
            INSERT INTO `user`  (`name`,    `email`,    `hashed_password`)
            VALUE               (:name,     :email,     :hashedPassword);
            '
        );

        $statement->bindValue(':name',              $user->getName());
        $statement->bindValue(':email',             $user->getEmail());
        $statement->bindValue(':hashedPassword',    $user->getHashedPassword());

        return $statement->execute();
    }
}
