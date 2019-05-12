<?php
require_once 'bootstrap.php';

$title = 'Добавление лота';

$connection = db_connect($config['db']);
$categories = get_categories($connection);
$lot = $_POST;


$dict = [
    'title' => 'Название',
    'message' => 'Описание',
    'file' => 'Изображение',
    'initial_price' => 'Начальная цена',
    'step_rate' => 'Шаг ставки',
    'category' => 'Категория',
    'lot_date' => 'Дата окончания ставок'
];

$errors = validate_lot($lot);



if ($_SERVER['REQUEST_METHOD']=='POST') {
    if (!$errors) {
        $tmp_name = $_FILES['lot_img']['tmp_name'];
        $path = $_FILES['lot_img']['name'];


        $filename = uniqid() . '.jpg';
        $lot['image'] = $filename;
        move_uploaded_file($tmp_name, 'uploads/' . $filename);

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
    } else {
        $page_content = include_template('add.php', [
            'categories' => $categories,
            'lot' => $lot,
            'errors' => $errors,
            'dict' => $dict
        ]);

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