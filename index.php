<?php
ini_set ('display_errors', 1);
ini_set ('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('Europe/Moscow');
require_once('helpers.php');
$config = require 'config.php';

$connection = db_connect($config['db']);

function db_connect($config_db)
{
    $connection = mysqli_connect(
        $config_db['host'],
        $config_db['user'],
        $config_db['password'],
        $config_db['database']
    );

    if (!$connection) {
        $error = mysqli_connect_error();
        die('Ошибка при подключении к БД: ' . $error);
    }

    mysqli_set_charset($connection, 'utf8');

    return $connection;
}

mysqli_set_charset($connection, "utf8_general_ci");

/**
 * @param $connection
 */
function get_categories($connection)
{
    $sql_cat = "SELECT title, code FROM category";
    $result_cat = mysqli_query($connection, $sql_cat);
    $categories = mysqli_fetch_all($result_cat, MYSQLI_ASSOC);

    return $categories;
}
$categories = get_categories($connection);

function get_lots($connection)
{
    $sql_lot = 'SELECT l.title AS title, l.initial_price AS price, l.image AS url_img, c.title AS categories FROM lot l JOIN category c ON c.id = l.category_id WHERE l.winner_id IS NULL ORDER BY l.create_time DESC';
    $result_lot = mysqli_query($connection, $sql_lot);
    $lots = mysqli_fetch_all($result_lot, MYSQLI_ASSOC);

    return $lots;
}
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
