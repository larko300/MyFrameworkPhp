<?php

namespace App\Controller;

use App\Model\Post;
use App\Model\User;
use App\View\View;

class PostController
{
    public function index()
    {
        View::render(['PostsList', 'AddPostForm'], Post::findAll());
    }

    public function create()
    {
        $user = User::getById(1);
        $post = new Post();
        $post->setBody($_POST['body']);
        $post->setOwner($user);
        $post->save();
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}
