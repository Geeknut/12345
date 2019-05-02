<?php
ini_set ('display_errors', 1);
ini_set ('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('Europe/Moscow');
require_once('helpers.php');

$con = mysqli_connect("localhost", "root", "", "yeticave");

mysqli_set_charset($con, "utf8_general_ci");


$sql_cat = "SELECT title, code FROM category";
$result_cat = mysqli_query($con, $sql_cat);
$categories = mysqli_fetch_all($result_cat, MYSQLI_ASSOC);

$sql_lot = 'SELECT l.title AS title, l.initial_price AS price, l.image AS url_img, c.title AS categories FROM lot l JOIN category c ON c.id = l.category_id WHERE l.winner_id IS NULL ORDER BY l.create_time DESC';
$result_lot = mysqli_query($con, $sql_lot);
$lots = mysqli_fetch_all($result_lot, MYSQLI_ASSOC);

$user_name = 'Катя'; // укажите здесь ваше имя
$is_auth = rand(0, 1);
$title = 'Главная';
/*$lots = [
	[
		'title' => '2014 Rossignol District Snowboard',
		'categories' => 'Доски и лыжи',
		'price' => '10999',
		'url_img' => 'img/lot-1.jpg'
	],
	[
		'title' => 'DC Ply Mens 2016/2017 Snowboard',
		'categories' => 'Доски и лыжи',
		'price' => '159999',
		'url_img' => 'img/lot-2.jpg'
	],
	[
		'title' => 'Крепления Union Contact Pro 2015 года размер L/XL',
		'categories' => 'Крепления',
		'price' => '8000',
		'url_img' => 'img/lot-3.jpg'
	],
	[
		'title' => 'Ботинки для сноуборда DC Mutiny Charocal',
		'categories' => 'Ботинки',
		'price' => '10999',
		'url_img' => 'img/lot-4.jpg'
	],
	[
		'title' => 'Куртка для сноуборда DC Mutiny Charocal',
		'categories' => 'Одежда',
		'price' => '7500',
		'url_img' => 'img/lot-5.jpg'
	],
	[
		'title' => 'Маска Oakley Canopy',
		'categories' => 'Разное',
		'price' => '5400',
		'url_img' => 'img/lot-6.jpg'
	]
];*/

//$categories = ['Доски и лыжи', 'Крепления', 'Ботинки', 'Одежда', 'Инструменты', 'Разное'];

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
