<?php

require_once 'debug.php';

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
    echo 'Page not found';
    return;
}

unset($matches[0]);

$controllerName = $controllerAndAction[0];
$actionName = $controllerAndAction[1];

$controller = new $controllerName;
$controller->$actionName(...$matches);





