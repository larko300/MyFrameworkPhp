<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>My app</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>
<div id="app">
    <main class="py-4">
        <div class="container">
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                <div class="container">
                    <a class="navbar-brand" href="/">
                        Project
                    </a>
                    <?php
                    if (!empty($data['user'])) { ?>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ml-auto">
                                <li class="nav-item">
                                    <a class="nav-link" href="/users/profile"><?= $data['user']->getName() ?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/users/logout">Logout</a>
                                </li>
                            </ul>
                        </div>
                    <?php } else {
                    ?>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ml-auto">
                                <li class="nav-item">
                                    <a class="nav-link" href="/users/register">Register</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/users/login">Login</a>
                                </li>
                            </ul>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </nav>
            <div class="row justify-content-center">