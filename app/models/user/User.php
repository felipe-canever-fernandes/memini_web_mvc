<?php

namespace App\Models\User;

require_once __DIR__ . '/../exceptions.php';
require_once __DIR__ . '/exceptions.php';

use PDO;

use App\Models\ValidationErrorException;
use Core\Model;

class User extends Model
{
    private int $id;
    private string $name;
    private string $email;
    private string $password;
    private string $hashedPassword;
    private bool $isAdministrator;

    public function __construct(
        string $name,
        string $email,
        string $password,
        bool $isPasswordHashed,
        bool $isAdministrator = false,
        int $id = 0
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

        $this->isAdministrator = $isAdministrator;
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
        if ($this->password == '')
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
        $this->password = '';
    }

    public function isAdministrator(): bool
    {
        return $this->isAdministrator;
    }

    public function setIsAdministrator(bool $isAdministrator): void
    {
        $this->isAdministrator = $isAdministrator;
    }

    /**
     * @throws ValidationErrorException
     */
    public static function save(User $user): bool
    {
        $connection = self::getConnection();

        $errors = self::validate($user);

        if (!empty($errors))
            throw new ValidationErrorException(self::class, $errors);

        $statement = $connection->prepare(
            '
            INSERT INTO `user`  (`name`,    `email`,    `hashed_password`,  `is_administrator`)
            VALUE               (:name,     :email,     :hashedPassword,   :isAdministrator);
            '
        );

        $statement->bindValue(':name',              $user->getName());
        $statement->bindValue(':email',             $user->getEmail());
        $statement->bindValue(':hashedPassword',    $user->getHashedPassword());
        $statement->bindValue(':isAdministrator',   $user->isAdministrator(), PDO::PARAM_BOOL);

        $result = $statement->execute();

        if (!$result)
            return false;

        $user->setId($connection->lastInsertId());

        return true;
    }

    public static function validate(User $user): array
    {
        $errors = [];

        if (self::emailExists($user->getEmail()))
            $errors['email'][] = 'This email has already been taken.';

        return $errors;
    }

    public static function findById(int $id)
    {
        $connection = self::getConnection();

        $statement = $connection->prepare(
            '
            SELECT `user_id`, `name`, `email`, `hashed_password`, `is_administrator`
            FROM `user`
            WHERE `user_id` = :id
            LIMIT 1;
            '
        );

        $statement->bindValue(':id', $id, PDO::PARAM_INT);

        $statement->execute();
        $result = $statement->fetch();

        if (!$result)
            return false;

        return new User(
            $result['name'],
            $result['email'],
            $result['hashed_password'],
            true,
            $result['is_administrator'],
            $result['user_id']
        );
    }

    public static function findByEmail(string $email)
    {
        $connection = self::getConnection();

        $statement = $connection->prepare(
            '
            SELECT `user_id`, `name`, `email`, `hashed_password`, `is_administrator`
            FROM `user`
            WHERE `email` = :email
            LIMIT 1;
            '
        );

        $statement->bindValue(':email', $email);

        $statement->execute();
        $result = $statement->fetch();

        if (!$result)
            return false;

        return new User(
            $result['name'],
            $result['email'],
            $result['hashed_password'],
            true,
            $result['is_administrator'],
            $result['user_id']
        );
    }

    private static function emailExists(string $email): bool
    {
        return self::findByEmail($email) !== false;
    }

    public static function authenticate(string $email, string $password)
    {
        $errors = [];
        $user = self::findByEmail($email);

        if (!$user) {
            $errors['email'][] = 'This email doesn\'t seem to belong to any user.';
            return $errors;
        }

        if (!password_verify($password, $user->getHashedPassword())) {
            $errors['password'][] = 'The password you entered is incorrect.';
            return $errors;
        }

        $user->setPassword($password);
        return $user;
    }

    public static function findAll(): array
    {
        $connection = self::getConnection();

        $statement = $connection->prepare(
            '
            SELECT `user_id`, `name`, `email`, `hashed_password`, `is_administrator`
            FROM `user`;
            '
        );

        $statement->execute();

        return array_map(
            fn ($result) => new User(
                $result['name'],
                $result['email'],
                $result['hashed_password'],
                true,
                $result['is_administrator'],
                $result['user_id']
            ),

            $statement->fetchAll()
        );
    }
}
