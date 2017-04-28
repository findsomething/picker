<?php

return function () {
    $files = array(
        dirname(__DIR__)."/../../../autoload.php",
        dirname(__DIR__)."/../vendor/autoload.php",
    );

    foreach ($files as $file) {
        if (is_file($file)){
            require_once $file;
            return true;
        }
    }
    return false;
};