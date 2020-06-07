<?php

use App\Controller\PostController;

$routes = [
    '/' => PostController::index()

];

$route = $_SERVER['REQUEST_URI'];

if (array_key_exists($route, $routes)) {
    echo $routes[$route];
    exit;
} else {
    http_response_code(404);
    echo 404;
}
