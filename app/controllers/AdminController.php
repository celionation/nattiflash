<?php

namespace app\controllers;

use app\classes\Permission;
use app\models\AdminUser;
use app\models\Articles;
use app\models\Categories;
use app\models\Regions;
use app\models\Users;
use core\Controller;
use core\helpers\CoreHelpers;
use core\helpers\FileUpload;
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

        if($this->currentUser->acl == 'admin') {
            $params = [
                'columns' => "articles.*, users.fname, users.lname, categories.name as category",
                'joins' => [
                    ['users', 'articles.user_id = users.id'],
                    ['categories', 'articles.category_id = categories.id', 'categories', 'LEFT']
                ],
                'order' => 'articles.id DESC'
            ];
        } else {
            $params = [
                'columns' => "articles.*, users.fname, users.lname, categories.name as category",
                'conditions' => "users.user_id = :user_id",
                'bind' => ['user_id' => $this->currentUser->user_id],
                'joins' => [
                    ['users', 'articles.user_id = users.id'],
                    ['categories', 'articles.category_id = categories.id', 'categories', 'LEFT']
                ],
                'order' => 'articles.id DESC'
            ];
        }

        $params = Articles::mergeWithPagination($params);
        $this->view->articles = Articles::find($params);
        $this->view->total = Articles::findTotal($params);

        $this->view->render();
    }

    /**
     * @throws Exception
     */
    public function articleAction($id = 'new')
    {
        Permission::permRedirect(['admin', 'author'], 'admin/dashboard');

        $params = [
            'conditions' => "id = :id AND user_id = :user_id",
            'bind' => ['id' => $id, 'user_id' => $this->currentUser->id]
        ];
        $article = $id == 'new' ? new Articles() : Articles::findFirst($params);
        if (!$article) {
            Session::msg("You do not have permission to edit this article");
            Router::redirect('admin/articles');
        }

        $categories = Categories::find(['order' => 'name']);
        $catOptions = [0 => 'Uncategorized'];
        foreach ($categories as $category) {
            $catOptions[$category->id] = $category->name;
        }

        $regions = Regions::find(['order' => 'name']);
        $regOptions = [0 => 'World'];
        foreach ($regions as $region) {
            $regOptions[$region->id] = $region->name;
        }

        if($this->request->isPost()) {
            Session::csrfCheck();
            $article->user_id = $this->currentUser->id;
            $article->title = $this->request->get('title');
            $article->body = $this->request->get('body');
            $article->status = $this->request->get('status');
            $article->category_id = $this->request->get('category_id');
            $article->region_id = $this->request->get('region_id');

            $upload = new FileUpload('img');

            if ($id != 'new') {
                $upload->required = false;
            }
            $uploadErrors = $upload->validate();
            if (!empty($uploadErrors)) {
                foreach ($uploadErrors as $field => $error) {
                    $article->setError($field, $error);
                }
            }

            if($article->save()) {
                if(!empty($upload->tmp)) {
                    if($upload->upload()) {
                        $article->img = $upload->fc;
                        $article->save();
                    }
                }
                Session::msg("{$article->title} saved.", 'success');
                Router::redirect('admin/articles');
            }
        }

        $this->view->article = $article;
        $this->view->hasImage = !empty($article->img);
        $this->view->statusOptions = ['private' => 'Private', 'public' => 'Public'];
        $this->view->categoryOptions = $catOptions;
        $this->view->regionOptions = $regOptions;
        $this->view->errors = $article->getErrors();
        $this->view->heading = $id === 'new' ? "Add Article" : "Edit Article";
        $this->view->render();
    }


    public function deleteArticleAction($id)
    {
        Permission::permRedirect(['admin', 'author'], 'admin');

        if ($this->currentUser->acl == 'admin') {
            $params = [
                'conditions' => "id = :id",
                'bind' => ['id' => $id]
            ];
        } else {
            $params = [
                'conditions' => "id = :id AND user_id = :user_id",
                'bind' => ['id' => $id, 'user_id' => $this->currentUser->id]
            ];
        }

        $article = Articles::findFirst($params);
        if ($article) {
            Session::msg("Article Deleted Successfully.", 'success');
            unlink(PROOT . DS . $article->img);
            $article->delete();
        } else {
            Session::msg("You do not have permission to delete that article");
        }
        Router::redirect('admin/articles');
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


    /**
     * @throws Exception
     */
    public function regionsAction()
    {
        Permission::permRedirect('admin', 'admin/dashboard');

        $params = ['order' => 'name'];
        $params = Regions::mergeWithPagination($params);
        $this->view->regions = Regions::find($params);
        $this->view->total = Regions::findTotal($params);
        $this->view->render();
    }

    /**
     * @throws Exception
     */
    public function regionAction($id = 'new')
    {
        Permission::permRedirect('admin', 'admin/dashboard');

        $region = $id == 'new' ? new Regions() : Regions::findById($id);
        if (!$region) {
            Session::msg("Region does not exist.");
            Router::redirect('admin/regions');
        }

        if ($this->request->isPost()) {
            Session::csrfCheck();
            $region->name = $this->request->get('name');
            if ($region->save()) {
                Session::msg('Region Saved!', 'success');
                Router::redirect('admin/regions');
            }
        }

        $this->view->region = $region;
        $this->view->heading = $id == 'new' ? "Add Region" : "Edit Region";
        $this->view->errors = $region->getErrors();
        $this->view->render();
    }

    public function deleteRegionAction($id)
    {
        Permission::permRedirect('admin', 'admin/dashboard');

        $region = Regions::findById($id);
        if (!$region) {
            Session::msg("That region does not exist");
            Router::redirect('admin/regions');
        }
        $region->delete();
        Session::msg("Region Deleted.", 'success');
        Router::redirect('admin/regions');
    }

}