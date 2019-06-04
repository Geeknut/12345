<?php
require_once 'bootstrap.php';
require_once 'functions/validators/login.php';

$title = 'Регистрация пользователя';

$connection = db_connect($config['db']);
$categories = get_categories($connection);

$login_data = getLoginData($_POST);

if ($_SERVER['REQUEST_METHOD']==='POST') {

    $errors = validate_login($login_data, $connection);

    if (!$errors ) {
        session_start();
        $user_name = find_name($connection, $login_data['email']);
        $_SESSION['username'] = $user_name;
        setcookie('username', $user_name, time()+60*60*24*30);
        header("Location: /");


    } else {
        $page_content = include_template('login.php', [
            'categories' => $categories,
            'user_data' => $login_data,
            'errors' => $errors
        ]);

    }

} else {
    $page_content = include_template('login.php', ['categories' => $categories]);
}

$layout_content = include_template('layout.php',[
    'content' => $page_content,
    'categories' => $categories,
    'title' => $title,
    'is_auth' => $is_auth,
    'user_name' => $user_name
]);

print($layout_content);