<?php

/**
 * Создает подготовленное выражение на основе готового SQL запроса и переданных данных
 *
 * @param $link mysqli Ресурс соединения
 * @param $sql string SQL запрос с плейсхолдерами вместо значений
 * @param array $data Данные для вставки на место плейсхолдеров
 *
 * @return mysqli_stmt Подготовленное выражение
 */
function db_get_prepare_stmt($link, $sql, $data = [])
{
    $stmt = mysqli_prepare($link, $sql);

    if ($stmt === false) {
        $errorMsg = 'Не удалось инициализировать подготовленное выражение: ' . mysqli_error($link);
        die($errorMsg);
    }

    if ($data) {
        $types = '';
        $stmt_data = [];

        foreach ($data as $value) {
            $type = 's';

            if (is_int($value)) {
                $type = 'i';
            } else if (is_string($value)) {
                $type = 's';
            } else if (is_double($value)) {
                $type = 'd';
            }

            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }

        $values = array_merge([$stmt, $types], $stmt_data);

        $func = 'mysqli_stmt_bind_param';
        $func(...$values);

        if (mysqli_errno($link) > 0) {
            $errorMsg = 'Не удалось связать подготовленное выражение с параметрами: ' . mysqli_error($link);
            die($errorMsg);
        }
    }

    return $stmt;
}

/**
 * Соединение с БД
 * @param $config_db
 * @return false|mysqli
 */

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

/**
 * Запрос на вывод категорий
 * @param $connection
 * @return array|null
 */
function get_categories($connection)
{
    $sql = "SELECT id, title, code FROM category";
    $result = mysqli_query($connection, $sql);
    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $categories;
}

/**
 * Запрос на вывод лотов
 * @param $connection
 * @return array|null
 */

function get_lots($connection)
{
    $sql = 'SELECT l.id, l.title AS lot_title, l.initial_price, l.image, c.title AS category_title FROM lot l JOIN category c ON c.id = l.category_id WHERE l.winner_id IS NULL ORDER BY l.create_time DESC';
    $result = mysqli_query($connection, $sql);
    $lots = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $lots;
}

/**
 * Получение данных лота по id
 * @param $connection
 * @return array|null
 */

function get_lot(mysqli $connection, int $id): ?array
{
    $sql = 'SELECT l.id, l.title, l.description, l.image, l.initial_price, l.end_time, l.step_rate, c.title AS category_title FROM lot l INNER JOIN category c ON c.id = l.category_id WHERE l.id = ' . $id;
    $result = mysqli_query($connection, $sql);
    $lot = mysqli_fetch_assoc($result);

    return $lot;
}

/**
 * Запрос на добавление лота
 * @param mysqli $connection
 * @param $lot_data
 * @return int|string
 */
function add_lot(mysqli $connection, $lot_data) {
    $sgl = 'INSERT INTO lot
(title, description, image, initial_price, end_time, step_rate, user_id, winner_id, category_id) VALUES (?, ?, ?, ?, ?, ?, 1, NULL, ? )';

    $stmt = db_get_prepare_stmt($connection, $sgl, [
        $lot_data['title'],
        $lot_data['description'],
        $lot_data['image'],
        $lot_data['initial_price'],
        $lot_data['end_time'],
        $lot_data['step_rate'],
        $lot_data['category_id']
    ]);

    $res = mysqli_stmt_execute($stmt);

    if (!$res) {
        die('Ошибка в выполнении запроса');
    }

    $lot_id = mysqli_insert_id($connection);

    return $lot_id;
}

/**
 * Запрос на добавление пользователя
 * @param mysqli $connection
 * @param $user_data
 * @return int|string
 */
function add_user(mysqli $connection, $user_data) {
    $sgl = 'INSERT INTO user (email, name, password, contacts) VALUES (?, ?, ?, ? )';

    $stmt = db_get_prepare_stmt($connection, $sgl, [
        $user_data['email'],
        $user_data['name'],
        password_hash($user_data['password'], PASSWORD_DEFAULT),
        $user_data['contacts']
    ]);

    $res = mysqli_stmt_execute($stmt);

    if (!$res) {
        die('Ошибка в выполнении запроса');
    }
    
    $user_id = mysqli_insert_id($connection);

    return $user_id;
}

/**
 * Получение id пользовалеля по e-mail
 * @param mysqli $connection
 * @param $email
 * @return array|null
 */
function find_email (mysqli $connection, $email): ?array {
    $sql = "SELECT id FROM `user` WHERE email = '$email'";
    $result = mysqli_query($connection, $sql);
    $user_id = mysqli_fetch_assoc($result);

    return $user_id;
}

/**
 * Получение пароля пользователя
 * @param mysqli $connection
 * @param $email
 * @return string|null
 *
 */
function find_password (mysqli $connection, $email): ?string {
    $sql = "SELECT password FROM `user` WHERE email = '$email'";
    $result = mysqli_query($connection, $sql);
    $user_password = mysqli_fetch_assoc($result);
    $user_password = current($user_password);

    return $user_password;
}

/**
 * Получение имени пользователя
 * @param mysqli $connection
 * @param $email
 * @return string|null
 */
function find_name (mysqli $connection, $email): ?string
{
    $sql = "SELECT name FROM `user` WHERE email = '$email'";
    $result = mysqli_query($connection, $sql);
    $user_name = mysqli_fetch_assoc($result);
    $user_name = current($user_name);

    return $user_name;
}
