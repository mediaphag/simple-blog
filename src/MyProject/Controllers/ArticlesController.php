<?php

namespace MyProject\Controllers;

use MyProject\Services\Db;
use MyProject\View\View;

class ArticlesController
{
    /** @var View */
    private $view;

    /** @var Db */
    private $db;

    /**
     * @param View $view
     * @param Db $db
     */
    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../../templates');
        $this->db = new Db();
    }

    public function view(int $articleId)
    {
        $result = $this->db->query(
            'SELECT * FROM `articles` WHERE id = :id;',
            [':id' => $articleId]
        );

        if ($result === []) {
            $this->view->renderHtml('errors/404.php', [], 404);
            return;
        }

        $resultFromUsers = $this->db->query(
            'SELECT * FROM `users` WHERE id = :id;',
            [':id' => $result[0]['author_id']]
        );

        $this->view->renderHtml('articles/view.php', [
            'article' => $result[0],
            'author' => $resultFromUsers[0]
        ]);
    }


}