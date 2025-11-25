<?php

session_start();

const REQUIRED_PHP_VERSION = '8.3';

// Check if the current PHP version meets the requirement
if (version_compare(PHP_VERSION, REQUIRED_PHP_VERSION, '<')) {
    header('HTTP/1.1 503 Service Unavailable');
    die('Your PHP version is ' . PHP_VERSION . '. This application requires PHP ' . REQUIRED_PHP_VERSION . ' or higher.');
}

define('ROOTPATH', __DIR__.DIRECTORY_SEPARATOR);

require "../app/core/init.php";

ini_set('display_errors', DEBUG ? 1 : 0);

$app = new App();
$app->loadController();