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
        $this->view->renderHtml('main/main.php', [
            'articles' => Article::getPage($pageNum, 5),
            'pagesCount' => Article::getPagesCount(5),
            'currentPageNum' => $pageNum,
            'previousPageLink' => $pageNum > 1 ? '/' . ($pageNum - 1) : null,
            'nextPageLink' => $pageNum < Article::getPagesCount(5) ? '/' . ($pageNum + 1) : null
        ]);
    }
}
