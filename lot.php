<?php
require_once 'bootstrap.php';


$title = '';

$connection = db_connect($config['db']);
$categories = get_categories($connection);
$user_id = find_user_id ($connection, $user_name);
$id = $_GET['id'] ?? null;

if (!$id) {
    die('Отсутствует обязательный параметр в запросе');
}

$lot = get_lot($connection, $id);

$max_cost = get_max_cost($connection);
$cost = getCostData($_POST['cost']);
$error = validate_cost($cost, $max_cost);

if ($lot) {

    if (!$error) {
        $rate_id = add_rate($connection, $cost, $user_id, $id);
        header("Location: cost.php?id=" . $rate_id);


    } else {
    $title = $lot['title'];
    $page_content = include_template('lot.php', [
        'lot' => $lot,
        'categories' => $categories,
        'is_auth' => $is_auth,
        'error' => $error
    ]);
}

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