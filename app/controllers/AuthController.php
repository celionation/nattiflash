<?php

namespace app\controllers;

use app\models\Users;
use core\Controller;
use core\Router;
use core\Session;
use Exception;

class AuthController extends Controller
{
    public function onConstruct()
    {
        $this->view->setLayout('auth');
    }

    /**
     * @throws Exception
     */
    public function registerAction()
    {
        $this->view->errors = [];
        $this->view->render();
    }

    /**
     * @throws Exception
     */
    public function loginAction()
    {
        $user = new Users();
        $isError = true;

        if($this->request->isPost()) {
            Session::csrfCheck();
            $user->email = $this->request->get('email');
            $user->password = $this->request->get('password');
            $user->remember = $this->request->get('remember');
            $user->validateLogin();
            if (empty($user->getErrors())) {
                //continue with the login process
                $u = Users::findFirst([
                    'conditions' => "email = :email",
                    'bind' => ['email' => $this->request->get('email')]
                ]);
                if ($u) {
                    $verified = password_verify($this->request->get('password'), $u->password);
                    if ($verified) {
                        //log the user in
                        $isError = false;
                        $remember = $this->request->get('remember') == 'on';
                        $u->login($remember);
                        Router::redirect('');
                    }
                }
            }
            if ($isError) {
                $user->setError('email', 'Something is wrong with the Email or Password. Please try again.');
                $user->setError('password', '');
            }
        }

        $this->view->errors = $user->getErrors();
        $this->view->user = $user;
        $this->view->render();
    }

    public function logoutAction()
    {
        global $currentUser;
        if ($currentUser) {
            $currentUser->logout();
        }
        Router::redirect('auth/login');
    }

}