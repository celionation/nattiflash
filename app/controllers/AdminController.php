<?php

namespace app\controllers;

use app\models\AdminUser;
use app\models\Users;
use core\Controller;
use core\helpers\CoreHelpers;
use core\Router;
use core\Session;
use Exception;

class AdminController extends Controller
{
    public function onConstruct()
    {
        $this->view->setLayout('admin');
    }

    /**
     * @throws Exception
     */
    public function registerAction($id = 'new')
    {
        if ($id == 'new') {
            $user = new Users();
        } else {
            $user = Users::findById($id);
        }

//        if (!$user) {
//            Session::msg("You do not have permission to edit this user");
//            Router::redirect('admin/dashboard');
//        }

        //if request is post
        if($this->request->isPost()) {
            Session::csrfCheck();
            $fields = ['fname', 'lname', 'email', 'acl', 'password', 'confirmPassword'];
            foreach ($fields as $field) {
                $user->{$field} = $this->request->get($field);
            }
            $user->save();
        }


        $this->view->user = $user;
        $this->view->acl = [
            '' => '',
            AdminUser::AUTHOR_PERMISSION => 'Author',
            AdminUser::ADMIN_PERMISSION => 'Admin',
            AdminUser::GUESTS_PERMISSION => 'Guests'
        ];
        $this->view->gender = [
            '' => '',
            AdminUser::MALE_GENDER => 'Male',
            AdminUser::FEMALE_GENDER => 'Female',
        ];
        $this->view->errors = $user->getErrors();
        $this->view->render();
    }
}