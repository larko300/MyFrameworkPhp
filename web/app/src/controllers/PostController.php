<?php

namespace App\Controller;
use App\Model\Post;
use App\Services\UsersAuthService;
use App\View\View;

class PostController
{
    public function index()
    {
        View::render(['PostsList', 'AddPostForm'], [
            'posts' => Post::findAll(),
            'user' => UsersAuthService::getUserByToken()
        ]);
    }

    public function create()
    {
        $post = new Post();
        $post->setBody($_POST['body']);
        $post->setOwner(UsersAuthService::getUserByToken());
        $post->save();
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}
