<?php

namespace App\Model;

class Post
{
    public function getAll()
    {
        return require "../app/src/data/Posts.php";
    }
}