<?php
include 'layout/LayoutStart.php';
$posts = include __DIR__ . '/../data/Posts.php';
include 'components/PostsList.php';
include 'components/AddPostForm.php';
include 'layout/LayoutEnd.php';
