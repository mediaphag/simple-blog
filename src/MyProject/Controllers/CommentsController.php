<?php

namespace MyProject\Controllers;

use MyProject\Exceptions\ForbiddenException;
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

    public function edit(int $commentId): void
    {
        if ($this->user === null) {
            throw new UnauthorizedException();
        }

        $comment = Comment::getById($commentId);
        if ($comment === null) {
            throw new NotFoundException('Comment not found');
        }

        if (!$this->user->isAdmin() && $comment->getUserId() !== $this->user->getId()) {
            throw new ForbiddenException('To edit the comment, you need to be author of the comment or have administrator rights');
        }
        $articleId = $comment->getArticleId();

        if (!empty($_POST)) {
            try {
                $comment->updateFromArray($_POST, $this->user, $commentId);
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('comments/edit.php', ['error' => $e->getMessage(), 'comment' => $comment]);
                return;
            }

            header('Location: /articles/' . $articleId . '#comment' . $comment->getId(), true, 302);
            exit();
        }

        $this->view->renderHtml('comments/edit.php', ['comment' => $comment]);
    }
}