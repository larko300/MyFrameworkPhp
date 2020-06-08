<?php

namespace App\Model;

use App\Exceptions\InvalidArgumentException;
use App\Model\ActiveRecordEntity;
use App\Services\UsersAuthService;

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

    public static function updateProfile(array $input, User $user): void
    {
        if (empty($input['name'])) {
            throw new InvalidArgumentException('Name empty');
        }

        if (empty($input['email'])) {
            throw new InvalidArgumentException('Email empty');
        }

        if (!preg_match('/^[a-zA-Z0-3]+$/', $input['name'])) {
            throw new InvalidArgumentException('Only latin alphabet for name input and min length is 3');
        }

        if (!filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Email incorrect');
        }

        if (static::findOneByColumn('email', $input['email']) !== null && $_POST['email'] !== $user->getEmail() ) {
            throw new InvalidArgumentException('This is email already usage');
        }

        $file_ext = strtolower(end(explode('.', $_FILES['image']['name'])));
        $expensions= ["jpeg","jpg","png"];
        if (in_array($file_ext,$expensions) === false && !empty($_FILES['image']['name'])) {
            throw new InvalidArgumentException('Extension not allowed, please choose a JPEG or PNG file');
        }

        if ($_FILES['image']['size'] > 2097152) {
            throw new InvalidArgumentException('File size must be less than 2 MB');
        }
        
        if (!empty($_FILES['image']['name'])) {
            $randomImageName = uniqid() . '.' . $file_ext;
            move_uploaded_file($_FILES['image']['tmp_name'],  $_SERVER['DOCUMENT_ROOT'] . '/../app/src/img/' . $randomImageName);
            $user->setImage($file_ext);
        }

        if ($input['email'] !== $user->getEmail()) {
            $user->setEmail($input['email']);
        }

        if ($input['name'] !== $user->getName()) {
            $user->setName($input['name']);
        }

        $user->save();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function getAuthToken(): string
    {
        return $this->authToken;
    }

    public function setAuthToken($authToken): void
    {
        $this->authToken = $authToken;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail($email): void
    {
        $this->email = $email;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setImage($image): void
    {
        $this->image = $image;
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
