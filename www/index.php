<?php

use MyProject\Models\Users\UsersAuthService;

require __DIR__ . '/../vendor/autoload.php';
require_once 'debug.php';



try {
//    spl_autoload_register(function (string $className) {
//        require_once __DIR__ . '/../src/' . str_replace('\\', '/', $className) . '.php';
//    });

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





