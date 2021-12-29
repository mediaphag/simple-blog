<?php

namespace MyProject\Models\Users;

use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Models\ActiveRecordEntity;

class User extends ActiveRecordEntity
{
    /** @var string */
    protected $nickname;

    /** @var string */
    protected $email;

    /** @var int */
    protected $isConfirmed;

    /** @var string */
    protected $role;

    /** @var string */
    protected $passwordHash;

    /** @var string */
    protected $authToken;

    /** @var string */
    protected $createdAt;

    /**
     * @return string
     */
    public function getNickname(): string
    {
        return $this->nickname;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return int
     */
    public function getIsConfirmed(): int
    {
        return $this->isConfirmed;
    }

    /**
     * @return string
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * @return string
     */
    public function getAuthToken(): string
    {
        return $this->authToken;
    }

    protected static function getTableName(): string
    {
        return 'users';
    }

    public static function signUp(array $userData): User
    {
        if (empty($userData['nickname'])) {
            throw new InvalidArgumentException('Nickname field is not filled');
        }

        if (!preg_match('/^[a-zA-Z0-9]+$/', $userData['nickname'])) {
            throw new InvalidArgumentException('Nickname can only consist of Latin characters and numbers');
        }

        if (empty($userData['email'])) {
            throw new InvalidArgumentException('Email field is not filled');
        }

        if (!filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Email is incorrect');
        }

        if (empty($userData['password'])) {
            throw new InvalidArgumentException('Password field is not filled');
        }

        if (mb_strlen($userData['password']) < 8) {
            throw new InvalidArgumentException('Password must be at least 8 characters');
        }

        if (static::findOneByColumn('nickname', $userData['nickname']) !== null) {
            throw new InvalidArgumentException('User with this nickname already exists');
        }

        if (static::findOneByColumn('email', $userData['email']) !== null) {
            throw new InvalidArgumentException('User with this email already exists');
        }

        $user = new User();
        $user->nickname = $userData['nickname'];
        $user->email = $userData['email'];
        $user->passwordHash = password_hash($userData['password'], PASSWORD_DEFAULT);
        $user->isConfirmed = (int)false;
        $user->role = 'user';
        $user->authToken = sha1(random_bytes(100)) . sha1(random_bytes(100));
        $user->save();

        return $user;
    }

    public function activate(): void
    {
        $this->isConfirmed = (int)true;
        $this->save();
    }

    public static function login(array $loginData): User
    {
        if (empty($loginData['email'])) {
            throw new InvalidArgumentException('Email field is not filled');
        }

        if (empty($loginData['password'])) {
            throw new InvalidArgumentException('Password field is not filled');
        }

        $user = User::findOneByColumn('email', $loginData['email']);
        if ($user === null) {
            throw new InvalidArgumentException('No user with this email');
        }

        if (!password_verify($loginData['password'], $user->getPasswordHash())) {
            throw new InvalidArgumentException('Invalid password');
        }

        if (!$user->isConfirmed) {
            throw new InvalidArgumentException('User not verified');
        }

        $user->refreshAuthToken();
        $user->save();

        return $user;
    }

    public function setNewPassword(array $userData,int $userId): User
    {
        if (empty($userData['password']) || empty($userData['secondPassword'])) {
            throw new InvalidArgumentException('Fields for entering a new password are not filled');
        }

        if ($userData['password'] !== $userData['secondPassword']) {
            throw new InvalidArgumentException('The entered values do not match');
        }

        $user = User::getById($userId);
        $user->passwordHash = password_hash($userData['password'], PASSWORD_DEFAULT);
        $user->save();

        return $user;

    }

    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    private function refreshAuthToken()
    {
        $this->authToken = sha1(random_bytes(100) . random_bytes(100));
    }

}