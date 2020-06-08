<?php

$routes = [
    '/' => ['App\Controller\PostController', 'index'],
    '/posts/create' => ['App\Controller\PostController', 'create'],
    '/users/register' => ['App\Controller\UserController', 'singUp'],
    '/users/login' => ['App\Controller\UserController', 'login'],
    '/users/profile' => ['App\Controller\UserController', 'profile'],
];

$route = $_SERVER['REQUEST_URI'];

if (array_key_exists($route, $routes)) {
    $class = new $routes[$route][0];
    $method = $routes[$route][1];
    $class->$method();
    exit;
} else {
    http_response_code(404);
    echo 404;
}
