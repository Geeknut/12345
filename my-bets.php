<?php
require_once 'bootstrap.php';
$connection = db_connect($config['db']);

$categories = get_categories($connection);

$rates = get_rates($connection);

$title = 'Мои ставки';
$remaining_minutes = 7;

$rates_time = get_noun_plural_form( $remaining_minutes, 'минута','минуты', 'минут');



$page_content = include_template('my-bets.php',[
    'rates' => $rates,
    'categories' => $categories,
    'remaining_minutes' => $remaining_minutes,
    'rates_time' => $rates_time
]);

$layout_content = include_template('layout.php',[
    'content' => $page_content,
    'categories' => $categories,
    'title' => $title,
    'is_auth' => $is_auth,
    'user_name' => $user_name
]);

print($layout_content);