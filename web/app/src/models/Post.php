<?php

namespace App\Model;

use App\Model\User;
use App\Model\ActiveRecordEntity;

class Post extends ActiveRecordEntity
{
    protected $body;

    protected $userId;

    protected $date;

    public function getBody(): string
    {
        return $this->body;
    }

    public function setBody($body): void
    {
        $this->body = $body;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function setDate($date): void
    {
       $this->date = $date;
    }

    public function getOwner()
    {
        return User::getById($this->userId);
    }

    public function setOwner(User $user): void
    {
        $this->userId = $user->getId();
    }

    protected static function getTableName(): string
    {
        return 'posts';
    }
}
