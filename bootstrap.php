<?php
ini_set ('display_errors', 1);
ini_set ('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('Europe/Moscow');
require_once 'functions/validators/lot.php';
require_once 'functions/validators/my-bets.php';

require_once 'functions/db.php';
require_once 'functions/template.php';
$config = require 'config.php';

//$user_name = 'Катя'; // укажите здесь ваше имя
//$is_auth = rand(0, 1);



if (isset($_COOKIE['username'])) {
    $is_auth = 1;
    $user_name = $_COOKIE['username'];
} else {
    $is_auth = 0;
    $user_name = 0;
}

