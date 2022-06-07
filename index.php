<?php

session_start();

use app\models\Users;
use \core\{Config, Router};
use Symfony\Component\Dotenv\Dotenv;

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

require_once(PROOT . DS . 'lib/dotenv/Dotenv.php');
require_once(PROOT . DS . 'lib/dotenv/Exception/ExceptionInterface.php');
require_once(PROOT . DS . 'lib/dotenv/Exception/FormatException.php');
require_once(PROOT . DS . 'lib/dotenv/Exception/FormatExceptionContext.php');
require_once(PROOT . DS . 'lib/dotenv/Exception/PathException.php');

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

//Dotenv Loading
$dotenv = new Dotenv();
$dotenv->load(PROOT . DS . '.env');

//check for logged-in user
$currentUser = Users::getCurrentUser();

$rootDir = Config::get('root_dir');
define('ROOT', $rootDir);

$url = $_SERVER['REQUEST_URI'];
if (ROOT != '/') {
    $url = str_replace(ROOT, '', $url);
} else {
    $url = ltrim($url, '/');
}
$url = preg_replace('/(\?.+)/', '', $url);

$currentPage = $url;

try {
    Router::route($url);
} catch (Exception $e) {
    echo $e;
}