<?php

namespace MyProject\Controllers;

use MyProject\View\View;

class MainController
{
    private $view;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../../templates');
    }


    public function main()
    {
        $articles = [
            ['name' => 'Article 1', 'text' => 'Text of article 1'],
            ['name' => 'Article 2', 'text' => 'Text of article 2'],
        ];
        $this->view->renderHtml('main/main.php', ['articles' => $articles]);
    }

    public function sayHello(string $name)
    {
        $this->view->renderHtml('main/hello.php', ['name' => $name, 'pageTitle' => 'Страница приветствия']);
    }

    public function sayBye(string $name)
    {
        echo 'Bye, ' . $name;
    }
}
