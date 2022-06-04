<?php

namespace app\controllers;

use core\Controller;
use Exception;

class AuthController extends Controller
{
    /**
     * @throws Exception
     */
    public function registerAction()
    {
        $this->view->setLayout('auth');
        $this->view->errors = [];
        $this->view->render();
    }

}