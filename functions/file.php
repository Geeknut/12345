<?php

function upload_file($file_data){
    $tmp_name = $file_data['tmp_name'];

    $path_info = pathinfo($tmp_name);

    $filename = uniqid() . '.' . $path_info['extension'];
    $lot['image'] = $filename;
    if (!move_uploaded_file($tmp_name, 'uploads/' . $filename)) {
        die('Ошибка загрузки файла, возможно нет прав на запись');
    }

    return $filename;
}