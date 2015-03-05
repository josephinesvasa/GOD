<?php
//test
session_start();
$_SESSION['auth'] = 'user';

require_once 'router.php';
require_once 'baseController.php';

function __autoload($class) {
    $class = './controllers/' . $class . '.php';

    require_once $class;
}

$router = new Router();
$controller = $router->getController();
$action = $router->getAction();

$obj = new $controller();
$obj->$action();;