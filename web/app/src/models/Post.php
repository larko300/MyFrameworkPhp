<?php

namespace App\Model;

use App\Exceptions\InvalidArgumentException;
use App\Model\ActiveRecordEntity;
use App\Services\UsersAuthService;

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

    public static function add($input){
        if (empty($input['body'])) {
            throw new InvalidArgumentException('Body empty');
        }
        $post = new Post();
        $post->setBody($input['body']);
        $post->setOwner(UsersAuthService::getUserByToken());
        $post->save();
    }

    protected static function getTableName(): string
    {
        return 'posts';
    }
}
