<?php

namespace App\Models\User;

require_once __DIR__ . '/../exceptions.php';

use App\Models\ValidationErrorException;
use Core\Model;

class User extends Model
{
    private int $id;
    private string $name;
    private string $email;
    private string $password;
    private string $hashedPassword;

    public function __construct(
        string $name, string $email, string $password, bool $isPasswordHashed = false, int $id = 0
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;

        if (!$isPasswordHashed) {
            $this->password = $password;
            $this->hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        } else {
            $this->password = '';
            $this->hashedPassword = $password;
        }
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

    /**
     * @throws PasswordNotSetException
     */
    public function getPassword(): string
    {
        if (empty($this->password))
            throw new PasswordNotSetException();

        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
        $this->setHashedPassword(password_hash($password, PASSWORD_DEFAULT));
    }

    public function getHashedPassword()
    {
        return $this->hashedPassword;
    }

    public function setHashedPassword($hashedPassword): void
    {
        $this->hashedPassword = $hashedPassword;
    }

    /**
     * @throws ValidationErrorException
     */
    public static function insert(User $user): bool
    {
        $connection = self::getConnection();

        $errors = self::validate($user);

        if (!empty($errors))
            throw new ValidationErrorException(self::class, $errors);

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

    public static function validate(User $user): array
    {
        $errors = [];

        if (self::emailExists($user->getEmail()))
            $errors['email'][] = 'This email has already been taken.';

        return $errors;
    }

    private static function emailExists(string $email): bool
    {
        $connection = self::getConnection();

        $statement = $connection->prepare(
            '
            SELECT *
            FROM `user`
            WHERE `email` = :email
            LIMIT 1;
            '
        );

        $statement->bindValue(':email', $email);

        $statement->execute();

        return $statement->fetch() !== false;
    }
}
