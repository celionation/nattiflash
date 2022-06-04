<?php

session_start();

use \core\{Config, Router};

//define constant
const PROOT = __DIR__;
const DS = DIRECTORY_SEPARATOR;
const TimeZone = 'Africa/Lagos';

function asset($url)
{
    $file_path = $url;
    $file_path = str_replace("\\", "/", $file_path);
    return str_replace("//", "/", $file_path);
}

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

$rootDir = Config::get('root_dir');
define('ROOT', $rootDir);

$url = $_SERVER['REQUEST_URI'];
if (ROOT != '/') {
    $url = str_replace(ROOT, '', $url);
} else {
    $url = ltrim($url, '/');
}
$url = preg_replace('/(\?.+)/', '', $url);

try {
    Router::route($url);
} catch (Exception $e) {
}