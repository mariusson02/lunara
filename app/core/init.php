<?php


spl_autoload_register(function($classname){
    if($classname !== 'AuthView') {
        require $filename = __DIR__ . "/../models/".ucfirst($classname).".php";
    }
});

require __DIR__ . "/config.php";
require __DIR__ . "/functions.php";
require __DIR__ . "/DatabaseConnection.php";
require __DIR__ . "/Model.php";
require __DIR__ . "/Controller.php";
require __DIR__ . "/App.php";
require __DIR__ . "/View.php";
require __DIR__ . "/Middleware.php";