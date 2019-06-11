<?php
/**
 * Проверка на существование элементы в форме
 * @param $cost
 * @return int
 */

function getCostData($array)
{
    $cost = $array ?? null;

    return $cost;
}


function validate_cost($cost, $max_cost) {
    if (empty($cost)) {
        $error = 'Нужно заполнить поле ставка';
        return $error;
    }
    if (intval($cost) <= 0 ) {
        $error = 'Ставка должна быть больше нуля';
        return $error;
    }
    if (intval($cost) <= intval($max_cost) ) {
        $error = 'Ставка должна быть больше максимальной';
        return $error;
    }

    return null;
}
