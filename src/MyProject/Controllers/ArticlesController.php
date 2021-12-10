<?php

namespace MyProject\Controllers;

use MyProject\Models\Articles\Article;
use MyProject\Models\Users\User;
use MyProject\View\View;

class ArticlesController
{
    /** @var View */
    private $view;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../../templates');
    }

    public function view(int $articleId)
    {
        $article = Article::getById($articleId);

        if ($article === null) {
            $this->view->renderHtml('errors/404.php', [], 404);
            return;
        }

        $this->view->renderHtml('articles/view.php', [
            'article' => $article
        ]);
    }

    public function edit(int $articleId): void
    {
        $article = Article::getById($articleId);

        if ($article === null) {
            $this->view->renderHtml('errors/404.php', [], 404);
            return;
        }

        $article->setName('Статья о том, как я погулял');
        $article->setText('Шел я значит по тротуару, как вдруг...');

        $article->save();
    }

    public function add(): void
    {
        $author = User::getById(1);

        $article = new Article();

        $article->setName('Новое название статьи 5');
        $article->setText('Новый текст статьи 5');
        $article->setAuthor($author);

        $article->save();

        var_dump($article);
    }

    public function delete(int $articleId): void
    {
        $article = Article::getById($articleId);

        if ($article === null) {
            $this->view->renderHtml('errors/notFound.php', [], 404);
            return;
        }

        $article->delete();

        var_dump($article);
    }
}