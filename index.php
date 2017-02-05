<?php
define('DEV_MODE', false);

if (defined('DEV_MODE') && DEV_MODE == true) {
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
}

try {
    require_once 'autoloader.php';
    $config = include_once 'config.php';
    $app = new App($config);
} catch (NotFoundPageException $e) {
    $app = new App($config, true);
} catch (Exception $e) {
    echo $e->getMessage();
}