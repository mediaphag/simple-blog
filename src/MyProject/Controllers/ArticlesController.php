<?php

namespace MyProject\Controllers;

use MyProject\Exceptions\NotFoundException;
use MyProject\Models\Articles\Article;
use MyProject\Models\Users\User;

class ArticlesController extends AbstractController
{

    public function view(int $articleId)
    {
        $article = Article::getById($articleId);

        if ($article === null) {
            throw new NotFoundException();
        }

        $this->view->renderHtml('articles/view.php', [
            'article' => $article
        ]);
    }

    public function edit(int $articleId): void
    {
        $article = Article::getById($articleId);

        if ($article === null) {
            throw new NotFoundException();
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
            throw new NotFoundException();
        }

        $article->delete();

        var_dump($article);
    }
}