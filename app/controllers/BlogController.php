<?php

namespace app\controllers;

use Core\Controller;

class BlogController extends Controller
{
    public function indexAction()
    {
        $this->view->setSiteTitle('Newest Articles');
        $this->view->render();
    }
}