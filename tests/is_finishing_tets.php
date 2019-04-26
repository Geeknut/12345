<?php
ini_set ('display_errors', 1);
ini_set ('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('Europe/Moscow');
require_once('../helpers.php');

$data = [
    [
        'date' => 'yesterday',
        'expected' => false
        ],
    [
        'date' => 'tomorrow',
        'expected' => true
    ],
    [
        'date' => date('Y-m-d H:i', time()+100),
        'expected' => true
    ]
];

//var_dump($data);

foreach ($data as $case) {
    $result = is_finishing($case['date']);
    if ($result !== $case['expected'] ) {
        var_dump($case);

        echo 'Функция вернула: ';
        var_dump($result);
        die();
    }
}

echo 'Тест пройден успешно!';





