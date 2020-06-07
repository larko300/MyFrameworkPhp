<?php

namespace App\Model;

use App\Model\ActiveRecordEntity;

class User extends ActiveRecordEntity
{
    protected $name;

    protected $email;

    protected $password;

    protected $image;

    public function getName(): string
    {
        return $this->name;
    }

    protected static function getTableName(): string
    {
        return 'users';
    }
}