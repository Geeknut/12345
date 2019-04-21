<?php
ini_set ('display_errors', 1);
ini_set ('display_startup_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set('Europe/Moscow');

$is_auth = rand(0, 1);

require_once('helpers.php');
	
$user_name = 'Катя'; // укажите здесь ваше имя

$lots = [
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
];

$categories = ['Доски и лыжи', 'Крепления', 'Ботинки', 'Одежда', 'Инструменты', 'Разное'];

const RUB = ' <b class="rub">₽</b>';

function format_price ($price) {	
	if ($price >= 1000) {
		$price = number_format($price, 0, ',', ' ');
	};
	
	return $price . RUB;
}

$title = 'Главная';
$endDate = '';

function time_to_end($endDate) {
	$time_tomorrow = strtotime($endDate);
	$cur_date = $time_tomorrow - time();
	$hours = floor($cur_date / 3600);
	$minutes = floor(($cur_date % 3600) / 60);
	print("$hours:$minutes");
};
function isFinishing($endDate){	
	if ($hours <= 1) {
		return 0;
	};	
	return 1;
};

$page_content = include_template('index.php',[
	'lots' => $lots, 
	'categories' => $categories, 
	'endDate' => $endDate
	]);

$layout_content = include_template('layout.php',[
	'content' => $page_content, 
	'categories' => $categories, 
	'title' => $title, 
	'is_auth' => $is_auth, 
	'user_name' => $user_name
	]);

print($layout_content);