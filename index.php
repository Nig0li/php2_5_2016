<?php

require __DIR__ . '/autoload.php';

$router = new \Components\Router();
$route = $router->process($_GET);
$controllerName = $route['controller'];
$actionName = $route['action'];

$controller = new $controllerName();
$logfile = new \Components\Logger();

try {
    $controller->action($actionName);
} catch (\Exceptions\Db $e) {
    $logfile->record($e);
    include __DIR__ . '/Templates/error.php';
} catch (\Exceptions\E404 $e) {
    $logfile->record($e);
    include __DIR__ . '/Templates/e404.php';
}