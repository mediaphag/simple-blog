<?php

namespace MyProject\Controllers;

use MyProject\Exceptions\ForbiddenException;
use MyProject\Exceptions\UnauthorizedException;
use MyProject\Models\Articles\Article;
use MyProject\Models\Comments\Comment;

class AdminController extends AbstractController
{
    private function checkAdminRights(): void
    {
        if ($this->user === null) {
            throw new UnauthorizedException();
        }

        if (!$this->user->isAdmin()) {
            throw new ForbiddenException('To enter the admin panel, you need to have administrator rights');
        }
    }

    public function dashbord(): void
    {
        $this->checkAdminRights();
        $this->view->renderHtml('admin/dashboard.php', ['pageTitle' => 'Admin panel']);
    }

    public function viewArticles(): void
    {
        $this->checkAdminRights();
        $articles = Article::findAll();
        $this->view->renderHtml('admin/articles.php', ['articles' => $articles, 'pageTitle' => 'Admin panel']);
    }

    public function viewComments(): void
    {
        $this->checkAdminRights();
        $comments = Comment::findAll();
        $this->view->renderHtml('admin/comments.php', ['comments' => $comments, 'pageTitle' => 'Admin panel']);
    }
}