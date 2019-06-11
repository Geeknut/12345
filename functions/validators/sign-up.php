<?php
/**
* Проверка на существование элементы в форме
* @param array $array
* @return array
*/
function getUserData(array $array) : array
{
    $user_data['email'] = $array['email'] ?? null;
    $user_data['password'] = $array['password'] ?? null;
    $user_data['name'] = $array['name'] ?? null;
    $user_data['contacts'] = $array['contacts'] ?? null;

    return $user_data;
}

/**
 * Проверяет на ошибки поле e-mail
 * @param $email
 * @param $connection
 * @return string|null
 */
function validate_user_email($email, $connection) {
    if (empty($email)) {
        return 'Введите email';
    }


    if (find_email($connection, $email) !== null) {

        return 'Пользователь с таким e-mail уже существует';
    }

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return null;
    } else {
        return 'Введите корректный e-mail';
    }

    return null;
}

/**
 * Проверяет на ошибки поле пароль
 * @param $password
 * @return string|null
 */
function validate_user_password($password) {
    if (empty($password)) {
        return 'Введите пароль';
    }

    return null;
}

/**
 * Проверяет на ошибки поле имя
 * @param $name
 * @return string|null
 */
function validate_user_name($name) {
    if (empty($name)) {
        return 'Введите имя';
    }

    return null;
}

/**
 * Проверяет на ошибки поле контакты
 * @param $contacts
 * @return string|null
 */
function validate_user_contacts($contacts) {
    if (empty($contacts)) {
        return 'Напишите как с вами связаться';
    }

    return null;
}

/**
 * Проверка массива ошибок на заполненность
 * @param $user
 * @param $connection
 * @return array
 */
function validate_sign_up($user, $connection) {
    $errors = [];

    if ($error = validate_user_email($user['email'], $connection)){
        $errors['email'] = $error;
    }

    if ($error = validate_user_password($user['password'])){
        $errors['password'] = $error;
    }

    if ($error = validate_user_name($user['name'])){
        $errors['name'] = $error;
    }

    if ($error = validate_user_contacts($user['contacts'])){
        $errors['contacts'] = $error;
    }

return $errors;
}