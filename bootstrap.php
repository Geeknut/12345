<?php
ini_set ('display_errors', 1);
ini_set ('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('Europe/Moscow');
require_once 'functions/validators/lot.php';
require_once 'functions/validators/sign-up.php';
require_once 'functions/db.php';
require_once 'functions/template.php';
$config = require 'config.php';

$user_name = 'Катя'; // укажите здесь ваше имя
$is_auth = rand(0, 1);

