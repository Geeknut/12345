<?php
    session_start();
    session_destroy();

    setcookie('username', '', time());
    $is_auth = 0;

    header("Location: /");
