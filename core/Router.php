<?php

namespace Core;

use app\controllers\BlogController;

class Router
{
    public static function route($url)
    {
        $controller = new BlogController('Blog', 'indexAction');
    }
}