<?php

session_start();

use \Core\Config;

//define constant
const PROOT = __DIR__;
const DS = DIRECTORY_SEPARATOR;

spl_autoload_register(function ($classname){
    $parts = explode('\\', $classname);
    $class = end($parts);
    array_pop($parts);
    $path = strtolower(implode(DS, $parts));
    $path = PROOT . DS . $path . DS . $class . '.php';
    if(file_exists($path)) {
        include($path);
    }
});

$dbname = Config::get('db_name');
var_dump($dbname);