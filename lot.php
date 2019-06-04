<?php
require_once 'bootstrap.php';


$title = '';

$connection = db_connect($config['db']);
$categories = get_categories($connection);
$id = $_GET['id'] ?? null;

if (!$id) {
    die('Отсутствует обязательный параметр в запросе');
}

$lot = get_lot($connection, $id);

if ($lot) {
    $title = $lot['title'];
    $page_content = include_template('lot.php',[
        'lot' => $lot,
        'categories' => $categories,
        'is_auth' => $is_auth
    ]);

} else {
    http_response_code(404);
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