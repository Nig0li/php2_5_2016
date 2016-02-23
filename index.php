<?php

require __DIR__ . '/autoload.php';

$router = new \Components\Router();
$route = $router->process($_GET);
$controllerName = $route['controller'];
$actionName = $route['action'];

$controller = new $controllerName();

try {
    $controller->action($actionName);
} catch (\Exceptions\Db $e) {
    include __DIR__ . '/Templates/error.php';
    $logfile = new \Components\Logger();
    $logfile->record($e);
} catch (\Exceptions\E404 $e) {
    include __DIR__ . '/Templates/e404.php';
    $logfile = new \Components\Logger();
    $logfile->record($e);
}