<?php
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
 * Проверка на существование элементы в форме
 * @param array $array
 * @return array
 */
function getLotData(array $array) : array
{
    $lot_data['title'] = $array['title'] ?? null;
    $lot_data['description'] = $array['description'] ?? null;
    $lot_data['end_time'] = $array['end_time'] ?? null;
    $lot_data['initial_price'] = isset($array['initial_price'] ) ? (int)$array['initial_price'] : null;
    $lot_data['step_rate'] = isset($array['step_rate'] ) ? (int)$array['step_rate'] : null;
    $lot_data['category_id'] = isset($array['category_id'] ) ? (int)$array['category_id'] : null;

    return $lot_data;
}

/**
 * Проверяет на ошибки поле название
 * @param $title
 * @return string|null
 */

function validate_lot_title($title) {
    if (empty($title)) {
        return 'Нужно заполнить название лота';
    } elseif (mb_strlen($title) > 128) {

        return 'Длина названия не должна быть больше 128 символов';
    }

    return null;
}

/**
 * Проверяет на ошибки поле описание
 * @param $description
 * @return string|null
 */
function validate_lot_description($description) {
    if (empty($description)) {
        return 'Нужно заполнить описание лота';
    } elseif (mb_strlen($description) > 500) {
        return 'Длина названия не должна быть больше 500 символов';
    }

    return null;
}

/**
 * Проверяет на ошибки поле изображение
 * @param $file_data
 * @return string|null
 */
function validate_lot_image($file_data)
{

    if ($file_data['error'] !== UPLOAD_ERR_NO_FILE) {

        $tmp_name = $file_data['tmp_name'];
        $path = $file_data['name'];

        $finfo = finfo_open(FILEINFO_MIME_TYPE);

        $file_type = finfo_file($finfo, $tmp_name);

        if ($file_type == "image/jpeg" || $file_type == "image/png") {
            return null;
        } else {
            return 'Загрузите картинку в формате jpg или png';
        }
    }

    return 'Вы не загрузили файл';
}

/**
 * Проверяет на ошибки поле цена
 * @param $initial_price
 * @return string|null
 */
function validate_lot_initial_price(int $initial_price) {
    if (empty($initial_price)) {
        return 'Нужно заполнить поле цены';
    }
    if ($initial_price <= 0 ) {
        return 'Цена должна быть больше нуля';
    }

    return null;
}

/**
 * Проверяет на ошибки поле дата окончания торгов
 * @param $end_time
 * @return string|null
 */
function validate_lot_end_time($end_time) {
    if (empty($end_time)) {
        return 'Нужно заполнить дату окончания торгов';
    }

    return null;
}

/**
 * Проверяет на ошибки поле шаг ставки
 * @param $step_rate
 * @return string|null
 */
function validate_lot_step_rate($step_rate) {
    if (empty($step_rate)) {
        return 'Нужно заполнить поле шаг ставки';
    }
    if ($step_rate <= 0 ) {
        return 'Шаг ставки должен быть больше нуля';
    }

    return null;
}

/**
 * Проверяет на ошибки поле катерогия лота
 * @param $category_id
 * @return string|null
 */
function validate_lot_category_id($category_id) {
    if (empty($category_id)) {
        return 'Выберите категорию лота';
    }

    return null;
}

/**
 * Проверка массива ошибок на заполненность
 * @param $lot
 * @param $file_data
 * @return array
 */
function validate_lot($lot, $file_data) {
    $errors = [];

    if ($error = validate_lot_title($lot['title'])){
        $errors['title'] = $error;
    }

    if ($error = validate_lot_image($file_data)){
        $errors['image'] = $error;
    }

    if ($error = validate_lot_description($lot['description'])){
        $errors['description'] = $error;
    }

    if ($error = validate_lot_end_time($lot['end_time'])){
        $errors['end_time'] = $error;
    }

    if ($error = validate_lot_initial_price($lot['initial_price'])){
        $errors['initial_price'] = $error;
    }

    if ($error = validate_lot_step_rate($lot['step_rate'])){
        $errors['step_rate'] = $error;
    }

    if ($error = validate_lot_category_id($lot['category_id'])){
        $errors['category_id'] = $error;
    }

    return $errors;
}

