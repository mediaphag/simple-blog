<?php

use MyProject\Cli\AbstractCommand;

require __DIR__ . '/../vendor/autoload.php';

try {
    unset($argv[0]);

    // Register the autoload function
//    spl_autoload_register(function (string $className) {
//        $fileName = __DIR__ . '/../src/' . str_replace('\\', '/', $className) . '.php';
//        if (file_exists($fileName)) {
//            require_once $fileName;
//        }
//    });

    // Make the full name of a class, having added namespace
    $className = '\\MyProject\\Cli\\' . array_shift($argv);
    if (!class_exists($className)) {
        throw new \MyProject\Exceptions\CliException('Class "' . $className . '" not found');
    }

    if (!is_subclass_of($className ,AbstractCommand::class)) {
        throw new \MyProject\Exceptions\CliException('Class "' . $className . '" must extends MyProject\Cli\AbstractCommand');
    }

    // Preparing a list of arguments
    $params = [];
    foreach ($argv as $argument) {
        preg_match('/^-(.+)=(.+)$/', $argument, $matches);
        if (!empty($matches)) {
            $paramName = $matches[1];
            $paramValue = $matches[2];

            $params[$paramName] = $paramValue;
        }
    }

    // Create an instance of a class, having transferred parameters and call method execute ()
    $class = new $className($params);
    $class->execute();
} catch (\MyPoject\Exceptions\CliException $e) {
    echo 'Error: ' . $e->getMessage();
}


