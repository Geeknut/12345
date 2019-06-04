<?php
require_once 'bootstrap.php';
require_once 'functions/file.php';

$title = 'Добавление лота';

$connection = db_connect($config['db']);
$categories = get_categories($connection);

$lot_data = getLotData($_POST);
if ($is_auth) {


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $file_data = $_FILES['image'] ?? null;

        $errors = validate_lot($lot_data, $file_data);


        if (!$errors) {
            $lot_data['image'] = upload_file($file_data);
            $lot_id = add_lot($connection, $lot_data);
            header("Location: lot.php?id=" . $lot_id);


        } else {
            $page_content = include_template('add.php', [
                'categories' => $categories,
                'lot' => $lot_data,
                'errors' => $errors
            ]);

        }


    } else {
        $page_content = include_template('add.php', ['categories' => $categories]);
    }

    $layout_content = include_template('layout.php', [
        'content' => $page_content,
        'categories' => $categories,
        'title' => $title,
        'is_auth' => $is_auth,
        'user_name' => $user_name
    ]);

    print($layout_content);
} else {
    header("HTTP/1.0 403 Forbidden");
}