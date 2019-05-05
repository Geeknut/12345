<?php
ini_set ('display_errors', 1);
ini_set ('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('Europe/Moscow');
require_once('helpers.php');
$config = require 'config.php';

$user_name = 'Катя'; // укажите здесь ваше имя
$is_auth = rand(0, 1);
$title = '';

$connection = db_connect($config['db']);
$categories = get_categories($connection);

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $lot = get_lot($connection, $id);

    if ($lot == NULL){
        $page_content = include_template('error.php',[
            'categories' => $categories
        ]);
    } else {
        $page_content = include_template('lot.php',[
            'lot' => $lot,
            'categories' => $categories
        ]);
    }
} else {
    $page_content = include_template('error.php',[
        'categories' => $categories
    ]);
}

$layout_content = include_template('layout.php',[
    'content' => $page_content,
    'categories' => $categories,
    'title' => $title,
    'is_auth' => $is_auth,
    'user_name' => $user_name
]);

print($layout_content);