<?php

namespace App\Model;

use App\Db;

class Post
{
    public function getAll()
    {
        $db = new Db\QueryBuilder();
        return $db->getAll('posts');
    }
}
