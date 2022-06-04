<?php

namespace app\controllers;

use Core\Controller;
use core\database\Database;
use core\helpers\CoreHelpers;
use Exception;

class BlogController extends Controller
{
    /**
     * @throws Exception
     */
    public function indexAction()
    {
        $db = Database::getInstance();
//        $sql = "INSERT INTO articles (`title`, `body`) VALUES (:title, :body)";
//        $bind = ['title' => 'new article', 'body' => 'article Body'];
//        $query = $db->execute($sql, $bind);
//        $lastId = $query->lastInsertId();
//        $db->insert('articles', ['title' => 'article', 'body' => 'body of article']);
        $db->update('articles', ['title' => 'article updated', 'body' => 'body of article updated'], ['id' => '7']);
//        CoreHelpers::dnd($lastId);
        $this->view->setSiteTitle('Newest Articles');
        $this->view->render();
    }
}