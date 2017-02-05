<?php
spl_autoload_register(function ($class) {

    if (substr_count($class, 'Abstract')) {
        $path = 'core/abstract/';
    } elseif(substr_count($class, 'Exception')) {
        $path = 'exceptions/';
    } elseif(substr_count($class, 'Service')) {
        $path = 'services/';
    } elseif(substr_count($class, 'Controller')) {
        $path = 'controllers/';
    } elseif(substr_count($class, 'Model')) {
        $path = 'models/';
    }  else {
        $path = 'core/';
    }

    $file = $path.$class.'.php';

    if (!file_exists($file)) {
        $result = defined('DEV_MODE') && DEV_MODE == true;
        $exceptionClass = ($result) ? 'Exception' : 'NotFoundPageException';

        throw new $exceptionClass($file .' is not exists');
    }

    include_once $file;
});

