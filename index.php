<?php
ini_set ('display_errors', 1);
ini_set ('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('Europe/Moscow');
require_once('helpers.php');
$config = require 'config.php';

$connection = db_connect($config['db']);

$categories = get_categories($connection);

$lots = get_lots($connection);

$user_name = 'Катя'; // укажите здесь ваше имя
$is_auth = rand(0, 1);
$title = 'Главная';

$page_content = include_template('index.php',[
    'lots' => $lots,
    'categories' => $categories
]);

$layout_content = include_template('layout.php',[
    'content' => $page_content,
    'categories' => $categories,
    'title' => $title,
    'is_auth' => $is_auth,
    'user_name' => $user_name
]);

print($layout_content);
