<?php

namespace Core;

use app\controllers\BlogController;
use Exception;

class Router
{
    /**
     * @throws Exception
     */
    public static function route($url)
    {
        $urlParts = explode('/', $url);

        // Set Controller
        $controller = !empty($urlParts[0]) ? $urlParts[0] : Config::get('default_controller');
        $controllerName = $controller;
        $controller = '\app\controllers\\' . ucwords($controller) . 'Controller';

        //Set Action
        array_shift($urlParts);
        $action = !empty($urlParts[0]) ? $urlParts[0] : 'index';
        $actionName = $action;
        $action .= 'Action';

        array_shift($urlParts);

        if (!class_exists($controller)) {
            throw new Exception("The controller \"{$controller}\" does not exist.");
        }
        $controllerClass = new $controller($controllerName, $actionName);

        if (!method_exists($controllerClass, $action)) {
            throw new Exception("The method \"{$action}\" does not exist on the \"{$controller}\" controller.");
        }
        call_user_func_array([$controllerClass, $action], $urlParts);
    }
}