<?php

namespace App\Controller;

use App\Model\Post;
use App\View\View;

class PostController
{
        public static function index()
        {
            $post = new Post();
            return View::render(['PostsList', 'AddPostForm'], $post->getAll());
        }
}