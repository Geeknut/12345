<?php
ini_set ('display_errors', 1);
ini_set ('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('Europe/Moscow');
require_once('helpers.php');

$end_date = '2019-04-22 21:00:00';

//$my_time = is_finishing($end_date);

var_dump( is_finishing($end_date));


