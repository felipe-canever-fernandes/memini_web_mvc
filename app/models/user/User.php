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
    public static function save(User $user): bool
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

    public static function findByEmail(string $email)
    {
        $connection = self::getConnection();

        $statement = $connection->prepare(
            '
            SELECT `user_id`, `name`, `email`, `hashed_password`
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
            intval($result['user_id'])
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
}
