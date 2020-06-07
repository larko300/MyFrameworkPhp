<?php

namespace App\Model;

use App\Exceptions\InvalidArgumentException;
use App\Model\ActiveRecordEntity;

class User extends ActiveRecordEntity
{
    protected $name;

    protected $email;

    protected $password;

    protected $image;

    protected $authToken;

    public static function signUp(array $input)
    {
        if (empty($input['name'])) {
            throw new InvalidArgumentException('Name empty');
        }

        if (!preg_match('/^[a-zA-Z0-3]+$/', $input['name'])) {
            throw new InvalidArgumentException('Only latin alphabet for name input and min length is 3');
        }

        if (empty($input['email'])) {
            throw new InvalidArgumentException('Email empty');
        }

        if (!filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Email incorrect');
        }

        if (empty($input['password'])) {
            throw new InvalidArgumentException('Password empty');
        }

        if (mb_strlen($input['password']) < 8) {
            throw new InvalidArgumentException('Min password length is 8');
        }
        if ($input['password'] != $input['password_confirmation']) {
            throw new InvalidArgumentException('Password mismatch');
        }

        if (static::findOneByColumn('email', $input['email']) !== null) {
            throw new InvalidArgumentException('This is email already usage');
        }

        $user = new User();
        $user->name = $input['name'];
        $user->email = $input['email'];
        $user->password = password_hash($input['password'], PASSWORD_DEFAULT);
        $user->authToken = sha1(random_bytes(100)) . sha1(random_bytes(100));
        $user->save();
        return $user;
    }

    public static function login(array $input): User
    {
        if (empty($input['email'])) {
            throw new InvalidArgumentException('Email empty');
        }

        if (!filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Email incorrect');
        }

        if (empty($input['password'])) {
            throw new InvalidArgumentException('Password empty');
        }

        $user = static::findOneByColumn('email', $input['email']);
        if ($user === null) {
            throw new InvalidArgumentException('Email not found');
        }

        if (!password_verify($input['password'], $user->getPassword())) {
            throw new InvalidArgumentException('Wrong password');
        }

        $user->refreshAuthToken();
        $user->save();
        return $user;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAuthToken(): string
    {
        return $this->authToken;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    private function refreshAuthToken()
    {
        $this->authToken = sha1(random_bytes(100)) . sha1(random_bytes(100));
    }

    protected static function getTableName(): string
    {
        return 'users';
    }
}
