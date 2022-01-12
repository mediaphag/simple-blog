<?php

namespace MyProject\Controllers;

use MyProject\Models\Articles\Article;

class MainController extends AbstractController
{
    public function main()
    {
        $this->page(1);
    }

    public function page(int $pageNum)
    {
        $pagesCount = Article::getPagesCount(5);
        $this->view->renderHtml('main/main.php', [
            'articles' => Article::getPage($pageNum, 5),
            'pagesCount' => $pagesCount,
            'currentPageNum' => $pageNum,
            'previousPageLink' => $pageNum > 1 ? '/' . ($pageNum - 1) : null,
            'nextPageLink' => $pageNum < $pagesCount ? '/' . ($pageNum + 1) : null
        ]);
    }
}
