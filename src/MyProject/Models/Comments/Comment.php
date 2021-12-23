<?php

namespace MyProject\Models\Comments;

use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Exceptions\NotFoundException;
use MyProject\Models\ActiveRecordEntity;
use MyProject\Models\Articles\Article;
use MyProject\Models\Users\User;

class Comment extends ActiveRecordEntity
{
    /**
     * @var int
     */
    protected $userId;

    /**
     * @var int
     */
    protected $articleId;

    /**
     * @var string
     */
    protected $text;



    protected static function getTableName(): string
    {
        return 'comments';
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getNickName(): string
    {
        $user = User::getById($this->getUserId());
        if ($user === null) {
            throw new NotFoundException('User not found');
        }

        return $user->getNickname();
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param User $author
     */
    public function setAuthor(User $author): void
    {
        $this->userId = $author->getId();
    }

    /**
     * @param int $articleId
     */
    public function setArticleId(int $articleId): void
    {
        $this->articleId = $articleId;
    }

    public function getArticleId(): int
    {
        return $this->articleId;
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public static function getByArticleId(int $articleId)
    {

    }

    public static function createFromArray(array $fields, User $author, int $articleId): Comment
    {
        if (empty($fields['text'])) {
            throw new InvalidArgumentException('The text of the comment has not been submitted');
        }

        $comment = new Comment();

        $comment->setAuthor($author);
        $comment->setArticleId($articleId);
        $comment->setText($fields['text']);

        $comment->save();

        return $comment;
    }




}