<?php

namespace app\controllers;

use Core\Controller;
use core\database\Database;
use core\helpers\CoreHelpers;

class BlogController extends Controller
{
    public function indexAction()
    {
        $db = Database::getInstance();
        $this->view->setSiteTitle('Newest Articles');
        $this->view->render();
    }
}