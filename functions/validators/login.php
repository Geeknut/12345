<?php
/**
 * Проверка на существование элементы в форме
 * @param array $array
 * @return array
 */
function getLoginData(array $array) : array
{
    $login_data['email'] = $array['email'] ?? null;
    $login_data['password'] = $array['password'] ?? null;

    return $login_data;
}




function validate_login_email($email, $connection) {
    if (empty($email)) {
        return 'Введите email';
    }
    if (find_email($connection, $email) == null) {

        return 'Пользователя с таким e-mail не существует';
    }


    return null;
}

function validate_login_password($password, $connection, $email) {
    if (empty($password)) {
        return 'Введите пароль';
    } else {
        $passwordHash = find_password($connection, $email);
        if (password_verify($password, $passwordHash )) {
            return null;
        } else {
            return 'Введен неверный пароль';
        }
    }
}



function validate_login($login, $connection) {
    $errors = [];

    if ($error = validate_login_email($login['email'], $connection)){
        $errors['email'] = $error;
    }

    if ($error = validate_login_password($login['password'], $connection, $login['email'])){
        $errors['password'] = $error;
    }



    return $errors;
}