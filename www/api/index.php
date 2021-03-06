<?php

require __DIR__ . '/../../vendor/autoload.php';

try {
    $route = $_GET['route'] ?? '';
    $routes = require __DIR__ . '/../../src/routes_api.php';

    $isRoutFound = false;
    foreach ($routes as $pattern => $controllerAndAction) {
        preg_match($pattern, $route, $matches);
        if (!empty($matches)) {
            $isRoutFound = true;
            break;
        }
    }

    if (!$isRoutFound) {
        throw new \MyProject\Exeptions\NotFoundExeption('Route not found');
    }

    unset($matches[0]);

    $controllerName = $controllerAndAction[0];
    $actionName = $controllerAndAction[1];

    $controller = new $controllerName();
    $controller->$actionName(...$matches);
} catch (\MyProject\Exceptions\DbException $e) {
    $view = new \MyProject\View\View(__DIR__ . '/../templates/errors');
    $view->displayJson(['error' => $e->getMessage()], 500);
} catch (\MyProject\Exceptions\NotFoundException $e) {
    $view = new \MyProject\View\View(__DIR__ . '/../templates/errors');
    $view->displayJson(['error' => $e->getMessage()], 404);
} catch (\MyProject\Exceptions\UnauthorizedException $e) {
    $view = new \MyProject\View\View(__DIR__ . '/../templates/errors');
    $view->displayJson(['error' => $e->getMessage()], 401);
}

