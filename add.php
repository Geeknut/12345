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

if ($_SERVER['REQUEST_METHOD']=='POST') {
    $lot = $_POST;

    $required = ['title', 'message', 'initial_price', 'initial_price', 'category', 'lot_date'];
    $dict = [
        'title' => 'Название',
        'message' => 'Описание',
        'file' => 'Изображение',
        'initial_price' => 'Начальная цена',
        'step_rate' => 'Шаг ставки',
        'category' => 'Категория',
        'lot_date' => 'Дата окончания ставок'
    ];
    $errors = [];
    foreach ($required as $key) {
        if (empty($_POST[$key])) {
            $errors[$key] = 'Это поле надо заполнить';
        }
    }

    if ($_FILES['lot_img']['name']!= 0) {

        $tmp_name = $_FILES['lot_img']['tmp_name'];
        $path = $_FILES['lot_img']['name'];

        $finfo = finfo_open(FILEINFO_MIME_TYPE);

        $file_type = finfo_file($finfo, $tmp_name);

        if ($file_type !== "image/jpeg") {
            $errors['file'] = 'Загрузите картинку в формате jpg';
        }  else {
            $filename = uniqid() . '.jpg';
            $lot['image'] = $filename;
            move_uploaded_file($tmp_name, 'uploads/' . $filename);

        }
    } else {
        $errors['file'] = 'Вы не загрузили файл';
    }

    if ($_POST['initial_price'] <= 0 ) {
        $errors['initial_price'] = 'Цена болжна быть больше нуля';
    }

    if ($_POST['step_rate'] <= 0 ) {
        $errors['step_rate'] = 'Шаг ставки должен быть больше нуля';
    }

    if (count($errors)) {
        $page_content = include_template('add.php', [
            'categories' => $categories,
            'lot' => $lot,
            'errors' => $errors,
            'dict' => $dict
        ]);
    } else {
        $sgl = 'INSERT INTO lot
(title, description, image, initial_price, end_time, step_rate, user_id, winner_id, category_id) VALUES (?, ?, ?, ?, ?, ?, 1, NULL, ? )';

        $stmt = db_get_prepare_stmt($connection, $sgl, [
            $lot['title'],
            $lot['message'],
            $lot['image'],
            $lot['initial_price'],
            $lot['lot_date'],
            $lot['step_rate'],
            $lot['category']
        ]);
        $res = mysqli_stmt_execute($stmt);

        if ($res) {
            $lot_id = mysqli_insert_id($connection);
            header("Location: lot.php?id=" . $lot_id);
        } else {
            die('Отсутствует обязательный параметр в запросе');
        }
    }

} else {
    $page_content = include_template('add.php', ['categories' => $categories]);
}

$layout_content = include_template('layout.php',[
    'content' => $page_content,
    'categories' => $categories,
    'title' => $title,
    'is_auth' => $is_auth,
    'user_name' => $user_name
]);

print($layout_content);