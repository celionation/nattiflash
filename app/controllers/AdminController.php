<?php

namespace app\controllers;

use app\classes\Permission;
use app\models\AdminUser;
use app\models\Categories;
use app\models\Users;
use core\Controller;
use core\helpers\CoreHelpers;
use core\Router;
use core\Session;
use Exception;

/**
 * @property bool $currentUser
 */
class AdminController extends Controller
{
    public function onConstruct()
    {
        $this->view->setLayout('admin');

        $this->currentUser = Users::getCurrentUser();

        Permission::permRedirect(['admin', 'author'], 'blog');
    }

    /**
     * @throws Exception
     */
    public function dashboardAction()
    {
        $this->view->render();
    }

    /**
     * @throws Exception
     */
    public function articlesAction()
    {
        Permission::permRedirect(['admin', 'author'], 'admin/dashboard');
        $this->view->render();
    }

    /**
     * @throws Exception
     */
    public function usersAction()
    {
        Permission::permRedirect('admin', 'admin/dashboard');
        $params = ['order' => 'lname, fname'];
        $params = Users::mergeWithPagination($params);
        $this->view->users = Users::find($params);
        $this->view->total = Users::findTotal($params);

        $this->view->render();
    }

    /**
     * @throws Exception
     */
    public function registerAction($id = 'new')
    {
        Permission::permRedirect('admin', 'admin/dashboard');
        if ($id == 'new') {
            $user = new Users();
        } else {
            $user = Users::findById($id);
        }

        if (!$user) {
            Session::msg("You do not have permission to edit this user");
            Router::redirect('admin/dashboard');
        }

        //if request is post
        if($this->request->isPost()) {
            Session::csrfCheck();
            $fields = ['fname', 'lname', 'email', 'acl', 'password', 'confirmPassword'];
            foreach ($fields as $field) {
                $user->{$field} = $this->request->get($field);
            }

            if ($id != 'new' && !empty($user->password)) {
                $user->resetPassword = true;
            }

            if($user->save()) {
                $msg = ($id == 'new') ? "User Created." : "User Updated";
                Session::msg($msg, 'success');
                Router::redirect('admin/users');
            }
        }


        $this->view->header = $id == 'new' ? 'Create New User with Permissions' : 'Edit User with Permissions';
        $this->view->user = $user;
        $this->view->acl = [
            '' => '',
            Users::AUTHOR_PERMISSION => 'Author',
            Users::ADMIN_PERMISSION => 'Admin',
            Users::GUESTS_PERMISSION => 'Guests'
        ];
        $this->view->gender = [
            '' => '',
            Users::MALE_GENDER => 'Male',
            Users::FEMALE_GENDER => 'Female',
        ];
        $this->view->errors = $user->getErrors();
        $this->view->render();
    }

    public function toggleUserAction($userId)
    {
        Permission::permRedirect('admin', 'admin/dashboard');
        $user = Users::findById($userId);
        if ($user) {
            $user->blocked = $user->blocked ? 0 : 1;
            $user->save();
            $msg = $user->blocked ? "User blocked." : "User unblocked.";
        }
        Session::msg($msg, 'success');
        Router::redirect('admin/users');
    }

    public function deleteUserAction($userId)
    {
        Permission::permRedirect('admin', 'admin/dashboard');
        $user = Users::findById($userId);
        $msgType = 'danger';
        $msg = 'User cannot be deleted';
        /** @var mixed $currentUser */
        if ($user && $user->id !== $this->currentUser->id) {
            $user->delete();
            $msgType = 'success';
            $msg = 'User deleted';
        }
        Session::msg($msg, $msgType);
        Router::redirect('admin/users');
    }


    /**
     * @throws Exception
     */
    public function categoriesAction()
    {
        Permission::permRedirect('admin', 'admin/dashboard');

        $params = ['order' => 'name'];
        $params = Categories::mergeWithPagination($params);
        $this->view->categories = Categories::find($params);
        $this->view->total = Categories::findTotal($params);
        $this->view->render();
    }

    /**
     * @throws Exception
     */
    public function categoryAction($id = 'new')
    {
        Permission::permRedirect('admin', 'admin/dashboard');

        $category = $id == 'new' ? new Categories() : Categories::findById($id);
        if (!$category) {
            Session::msg("Category does not exist.");
            Router::redirect('admin/categories');
        }

        if ($this->request->isPost()) {
            Session::csrfCheck();
            $category->name = $this->request->get('name');
            if ($category->save()) {
                Session::msg('Category Saved!', 'success');
                Router::redirect('admin/categories');
            }
        }

        $this->view->category = $category;
        $this->view->heading = $id == 'new' ? "Add Category" : "Edit Category";
        $this->view->errors = $category->getErrors();
        $this->view->render();
    }

    public function deleteCategoryAction($id)
    {
        Permission::permRedirect('admin', 'admin/dashboard');

        $category = Categories::findById($id);
        if (!$category) {
            Session::msg("That category does not exist");
            Router::redirect('admin/categories');
        }
        $category->delete();
        Session::msg("Category Deleted.", 'success');
        Router::redirect('admin/categories');
    }

}