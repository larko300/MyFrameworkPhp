<?php

namespace App\Controller;

use App\Model\Post;
use App\Model\User;
use App\View\View;

class PostController
{
    public static function index()
    {
        return View::render(['PostsList', 'AddPostForm'], Post::findAll());
    }
}
