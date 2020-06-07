<?php

$routes = [
    '/' => ['App\Controller\PostController', 'index'],
    '/post/create' => ['App\Controller\PostController', 'create'],
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