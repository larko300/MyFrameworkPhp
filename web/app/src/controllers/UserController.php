<?php

namespace App\Controller;

use App\Exceptions\InvalidArgumentException;
use App\Model\User;
use App\Services\UsersAuthService;
use App\View\View;

class UserController
{
    public function singUp()
    {
        if (!empty($_POST)) {
            try {
                $user = User::signUp($_POST);
            } catch (InvalidArgumentException $e) {
                View::render('RegisterForm', $e->getMessage());
                exit();
            }
            if ($user instanceof User) {
                session_start();
                $_SESSION['flesh'] = 'Success. Please sign in.';
                header('Location: /users/login');
                exit();
            }
        }
        View::render('RegisterForm');
    }


    public function login()
    {
        if (!empty($_POST)) {
            try {
                $user = User::login($_POST);
                UsersAuthService::createToken($user);
                header('Location: /');
                exit();
            } catch (InvalidArgumentException $e) {
                View::render('LoginForm', [
                    'error' => $e->getMessage()
                ]);
                exit();
            }
        }
        View::render('LoginForm');
    }

    public function profile()
    {
        $user = UsersAuthService::getUserByToken();
        if (!empty($_POST)) {
            try {
                User::updateProfile($_POST, $user);
                session_start();
                $_SESSION['flesh'] = 'Success';
                header('Location: /users/profile');
                exit();
            } catch (InvalidArgumentException $e) {
                View::render('Profile', [
                    'error' => $e->getMessage()
                ]);
                exit();
            }
        }
        if (!empty($user) && empty($_POST)) {
            View::render('Profile', [
                'user' => $user
            ]);
            exit();
        } else {
            header('Location: /');
        }
    }
}
