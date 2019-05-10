<?php
const RUB = ' <b class="rub">₽</b>';
const HOUR = 3600;

/**
 * Проверяет переданную дату на соответствие формату 'ГГГГ-ММ-ДД'
 *
 * Примеры использования:
 * is_date_valid('2019-01-01'); // true
 * is_date_valid('2016-02-29'); // true
 * is_date_valid('2019-04-31'); // false
 * is_date_valid('10.10.2010'); // false
 * is_date_valid('10/10/2010'); // false
 *
 * @param string $date Дата в виде строки
 *
 * @return bool true при совпадении с форматом 'ГГГГ-ММ-ДД', иначе false
 */
function is_date_valid(string $date) : bool {
    $format_to_check = 'Y-m-d';
    $dateTimeObj = date_create_from_format($format_to_check, $date);

    return $dateTimeObj !== false && array_sum(date_get_last_errors()) === 0;
}

/**
 * Создает подготовленное выражение на основе готового SQL запроса и переданных данных
 *
 * @param $link mysqli Ресурс соединения
 * @param $sql string SQL запрос с плейсхолдерами вместо значений
 * @param array $data Данные для вставки на место плейсхолдеров
 *
 * @return mysqli_stmt Подготовленное выражение
 */
function db_get_prepare_stmt($link, $sql, $data = []) {
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
            }
            else if (is_string($value)) {
                $type = 's';
            }
            else if (is_double($value)) {
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
 * Возвращает корректную форму множественного числа
 * Ограничения: только для целых чисел
 *
 * Пример использования:
 * $remaining_minutes = 5;
 * echo "Я поставил таймер на {$remaining_minutes} " .
 *     get_noun_plural_form(
 *         $remaining_minutes,
 *         'минута',
 *         'минуты',
 *         'минут'
 *     );
 * Результат: "Я поставил таймер на 5 минут"
 *
 * @param int $number Число, по которому вычисляем форму множественного числа
 * @param string $one Форма единственного числа: яблоко, час, минута
 * @param string $two Форма множественного числа для 2, 3, 4: яблока, часа, минуты
 * @param string $many Форма множественного числа для остальных чисел
 *
 * @return string Рассчитанная форма множественнго числа
 */
function get_noun_plural_form (int $number, string $one, string $two, string $many): string
{
    $number = (int) $number;
    $mod10 = $number % 10;
    $mod100 = $number % 100;

    switch (true) {
        case ($mod100 >= 11 && $mod100 <= 20):
            return $many;

        case ($mod10 > 5):
            return $many;

        case ($mod10 === 1):
            return $one;

        case ($mod10 >= 2 && $mod10 <= 4):
            return $two;

        default:
            return $many;
    }
}

/**
 * Подключает шаблон, передает туда данные и возвращает итоговый HTML контент
 * @param string $name Путь к файлу шаблона относительно папки templates
 * @param array $data Ассоциативный массив с данными для шаблона
 * @return string Итоговый HTML
 */
function include_template($name, array $data = []) {
    $name = 'templates/' . $name;
    $result = '';

    if (!is_readable($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
}

/**
 * Ставит пробел после тысячи и добавляет знак рубля
 * @param int $price цена
 * @return string
 */
function format_price (int $price): string
{
    if ($price >= 1000) {
        $price = number_format($price, 0, ',', ' ');
    };

    return $price . RUB;
}

/**
 * Вычисляет кол-во часов и минут до указанной даты
 * @param string $end_date дата
 * @return string
 */
function time_to_end(string $end_date): string
{
    $end_time = strtotime($end_date);
    $seconds_left = $end_time - time();
    $hours = floor($seconds_left / HOUR);
    $minutes = floor(($seconds_left % HOUR) / 60);
    $hours = sprintf("%02d", $hours);
    $minutes = sprintf("%02d", $minutes);
    return $hours.':'.$minutes;
};

/**
 * Определяет что осталось меньше часа до окончания лота
 * @param string $end_date дата
 * @return bool
 */
function is_finishing(string $end_date): bool
{
    $end_time = strtotime($end_date);
    $seconds_left = $end_time - time();
    if ($seconds_left <= 0 || $seconds_left > HOUR) {
        return false;
    }
    return true;
};

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

function get_lot(mysqli $connection, int $id) : ?array
{
    $sql = 'SELECT l.id, l.title, l.description, l.image, l.initial_price, l.end_time, l.step_rate, c.title AS category_title FROM lot l INNER JOIN category c ON c.id = l.category_id WHERE l.id = '.$id;
    $result = mysqli_query($connection, $sql);
    $lot = mysqli_fetch_assoc($result);

    return $lot;
}
