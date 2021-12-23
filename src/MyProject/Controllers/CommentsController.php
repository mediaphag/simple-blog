<?php

namespace MyProject\Controllers;

use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Exceptions\NotFoundException;
use MyProject\Exceptions\UnauthorizedException;
use MyProject\Models\Articles\Article;
use MyProject\Models\Comments\Comment;

class CommentsController extends AbstractController
{
    public function add(int $articleId): void
    {
        if ($this->user === null) {
            throw new UnauthorizedException();
        }

        if (Article::getById($articleId) === null) {
            throw new NotFoundException('Article not found');
        }


        if (!empty($_POST)) {
            try {
                $comment = Comment::createFromArray($_POST, $this->user, $articleId);
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('articles/view.php', ['error' => $e->getMessage()]);
                return;
            }

            header('Location: /articles/' . $articleId . '#comment' . $comment->getId(), true, 302);
            exit();
        }

        header('Location: /articles/' . $articleId, true, 302);
        exit();
    }
}