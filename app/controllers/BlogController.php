<?php

namespace app\controllers;

use app\models\Articles;
use app\models\Categories;
use app\models\Users;
use Core\Controller;
use core\helpers\CoreHelpers;
use core\Router;
use core\Session;
use Exception;

class BlogController extends Controller
{
    /**
     * @throws Exception
     */
    public function indexAction()
    {
        $this->view->setSiteTitle('Newest Articles');
        $this->view->render();
    }


    /**
     * @throws Exception
     */
    public function newsAction()
    {
        $params = [
            'columns' => "articles.*, users.fname, users.lname, categories.name as category, regions.name as region",
            'conditions' => "articles.status = :status",
            'bind' => ['status' => 'public'],
            'joins' => [
                ['users', 'articles.user_id = users.id'],
                ['categories', 'articles.category_id = categories.id', 'categories', 'LEFT'],
                ['regions', 'articles.region_id = regions.id', 'regions', 'LEFT']
            ],
            'order' => 'articles.created_at DESC'
        ];
        $params = Articles::mergeWithPagination($params);
        $this->view->articles = Articles::find($params);
        $this->view->total = Articles::findTotal($params);

        $this->view->render();
    }


    /**
     * @throws Exception
     */
    public function sportsAction()
    {
        $this->view->render();
    }


    /**
     * @throws Exception
     */
    public function entertainmentAction()
    {
        $this->view->render();
    }

    /**
     * @throws Exception
     */
    public function categoryAction($categoryId)
    {
        $params = [
            'columns' => "articles.*, users.fname, users.lname, categories.name as category, regions.name as region",
            'conditions' => "articles.category_id = :catId AND articles.status = :status",
            'bind' => ['status' => 'public', 'catId' => $categoryId],
            'joins' => [
                ['users', 'articles.user_id = users.id'],
                ['categories', 'articles.category_id = categories.id', 'categories', 'LEFT'],
                ['regions', 'articles.region_id = regions.id', 'regions', 'LEFT']
            ],
            'order' => 'articles.created_at DESC'
        ];
        $params = Articles::mergeWithPagination($params);
        if ($categoryId == 0) {
            $category = new Categories();
            $category->id = 0;
            $category->name = "Uncategorized";
        } else {
            $category = Categories::findById($categoryId);
        }
        if (!$category) {
            Session::msg('That category does not exist', 'warning');
            Router::redirect('blog');
        }
        $this->view->articles = Articles::find($params);
        $this->view->total = Articles::findTotal($params);
        $this->view->render('blog/news');
    }

    /**
     * @throws Exception
     */
    public function authorAction($authorId)
    {
        $author = Users::findById($authorId);
        if (!$author) {
            Session::msg("That author does not exist.", 'warning');
            Router::redirect('blog');
        }
        $params = [
            'columns' => "articles.*, users.fname, users.lname, categories.name as category, regions.name as region",
            'conditions' => "articles.user_id = :authorId AND articles.status = :status",
            'bind' => ['authorId' => $authorId, 'status' => 'public'],
            'joins' => [
                ['users', 'articles.user_id = users.id'],
                ['categories', 'articles.category_id = categories.id', 'categories', 'LEFT'],
                ['regions', 'articles.region_id = regions.id', 'regions', 'LEFT']
            ],
            'order' => 'articles.id DESC'
        ];
        $params = Articles::mergeWithPagination($params);
        $this->view->articles = Articles::find($params);
        $this->view->total = Articles::findTotal($params);
        $this->view->heading = "Author: {$author->displayName()}";
        $this->view->setSiteTitle('Newest Articles');
        $this->view->render('blog/news');
    }


    /**
     * @throws Exception
     */
    public function readAction($id)
    {
        $params = [
            'columns' => "articles.*, users.fname, users.lname, category.name as category, category.id as category_id, region.name as region",
            'conditions' => "articles.id = :id AND articles.status = 'public'",
            'joins' => [
                ['users', 'users.id = articles.user_id'],
                ['categories', 'category.id = articles.category_id', 'category', 'LEFT'],
                ['regions', 'region.id = articles.region_id', 'region', 'LEFT']
            ],
            'bind' => ['id' => $id]
        ];
        $article = Articles::findFirst($params);
        if (!$article) Router::redirect('blog/articleNotFound');
        if (empty($article->category_id)) {
            $article->category_id = 0;
            $article->category = "Uncategorized";
        }
        if (empty($article->region_id)) {
            $article->region_id = 0;
            $article->region = "World";
        }
        $this->view->article = $article;
        $this->view->render();
    }

    /**
     * @throws Exception
     */
    public function articleNotFoundAction()
    {
        $this->view->render();
    }

}