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


function validate_lot($lot) {


    $required = ['title', 'message', 'initial_price', 'initial_price', 'category', 'lot_date'];

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

    return $errors;
}