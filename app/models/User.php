<?php

namespace App\Models;

use Core\Model;

class User extends Model
{
    private int $id;
    private string $name;
    private string $email;
    private string $password;

    public function __construct(string $name, string $email, string $password, int $id = 0)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
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

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
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
        $statement->bindValue(':hashedPassword',    password_hash($user->getPassword(), PASSWORD_DEFAULT));

        return $statement->execute();
    }
}
