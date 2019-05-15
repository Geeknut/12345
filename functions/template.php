<?php
const RUB = ' <b class="rub">₽</b>';
const HOUR = 3600;

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