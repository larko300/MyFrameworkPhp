<?php


use App\Controller\PostController;
use App\Model\Post;

$routes = [
    '/' => PostController::index(),
    '/register' => '../app/src/view/Register.php'

];


$route = $_SERVER['REQUEST_URI'];


if (array_key_exists($route, $routes)) {
    echo $routes[$route];
    exit;
} else {
    echo 404;
}