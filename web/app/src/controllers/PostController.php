<?php

namespace App\Controller;
use App\Exceptions\InvalidArgumentException;
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
        try {
            Post::add($_POST);
            $_SESSION['flesh'] = 'Success';
            header('Location: /');
            exit();
        } catch (InvalidArgumentException $e) {
            View::render('Profile', [
                'posts' => Post::findAll(),
                'user' => UsersAuthService::getUserByToken(),
                'error' => $e->getMessage()
            ]);
            exit();
        }
    }
}
