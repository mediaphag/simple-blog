<?php

use MyProject\Models\Users\UsersAuthService;

require_once 'debug.php';

//Lesson 26
//try {
//    throw new Exception('Сообщение об ошибке', 123);
//} catch (Exception $e) {
//    echo 'Было поймано исключение: ' . $e->getMessage() . '. Код: ' . $e->getCode();
//}

//function func1()
//{
//    try {
//        func2();
//    } catch (Exception $e)
//    {
//        echo 'Было поймано исключение: ' . $e->getMessage();
//    }
//
//    echo 'А теперь выполнится этот код';
//}
//
//function func2()
//{
//    func3();
//}
//
//function func3()
//{
//    throw new Exception('Ошибка при подключении к БД');
//
//    echo 'Этот код не выполнится, так как идет после места, где было брошено исключение';
//}
//
//func1();
//end Lesson 26 part 1

try {
    spl_autoload_register(function (string $className) {
        require_once __DIR__ . '/../src/' . str_replace('\\', '/', $className) . '.php';
    });

//$author = new \MyProject\Models\Users\User('John');
//$article = new \MyProject\Models\Articles\Article('New cool longread', 'Text of longread', $author);

//$controller = new \MyProject\Controllers\MainController();
//
//if (!empty($_GET['name'])) {
//    $controller->sayHello($_GET['name']);
//} else {
//    $controller->main();
//}

//echo $_SERVER['SCRIPT_NAME'] . '?' . $_SERVER['QUERY_STRING'];


    $route = $_GET['route'] ?? '';
    $routes = require __DIR__ . '/../src/routes.php';

    $isRouteFound = false;
    foreach ($routes as $pattern => $controllerAndAction) {
        preg_match($pattern, $route, $matches);
        if (!empty($matches)) {
            $isRouteFound = true;
            break;
        }
    }

    if (!$isRouteFound) {
        throw new \MyProject\Exceptions\NotFoundException();
    }

    unset($matches[0]);

    $controllerName = $controllerAndAction[0];
    $actionName = $controllerAndAction[1];

    $controller = new $controllerName;
    $controller->$actionName(...$matches);
} catch (\MyProject\Exceptions\DbException $e) {
    $view = createView();
    $view->renderHtml('500.php', ['error' => $e->getMessage()], 500);
} catch (\MyProject\Exceptions\NotFoundException $e) {
    $view = createView();
    $view->renderHtml('404.php', ['error' => $e->getMessage()], 404);
} catch (\MyProject\Exceptions\UnauthorizedException $e) {
    $view = createView();
    $view->renderHtml('401.php', ['error' => $e->getMessage()], 401);
} catch (\MyProject\Exceptions\ForbiddenException $e) {
    $view = createView();
    $view->renderHtml('403.php', ['error' => $e->getMessage()], 403);
}

function createView(): \MyProject\View\View
{
    $view = new MyProject\View\View(__DIR__ . '/../templates/errors');
    $user = UsersAuthService::getUserByToken();
    $view->setVar('user', $user);
    return $view;
}





