<?php
<<<<<<< HEAD
//test
class Router {
=======
session_start();

require_once('./controllers/userController.php');
require_once('./controllers/adminController.php');
require_once('./controllers/roomController.php');
require_once('./controllers/messageController.php');
>>>>>>> origin/master

$uri = explode('/', parse_url(strtolower(rtrim($_SERVER['REQUEST_URI'], '/')), PHP_URL_PATH));
$script = explode('/', parse_url(strtolower(rtrim($_SERVER['SCRIPT_NAME'], '/')), PHP_URL_PATH));

for ($i = 0; $i < count($script); $i++) {
    if (isset($uri[$i]) && $uri[$i] == $script[$i]) {
        unset($uri[$i]);
    }
}

$path = array_values($uri);

if (empty($_SESSION['status'])) {
    echo 'SHOW LOGIN PAGE!';
}
else {
    if (count($path) == 0) {
        echo 'Include chat.php';
    }
    elseif (count($path) == 1) {
        if ($path[0] == 'settings') {
            echo 'Include settings.php';
        }
        elseif ($path[0] == 'admin') {
            if (!empty($_SESSION['admin'])) {
                echo 'Include admin.php';
            }
            else {
                echo 'ERROR 404!';
            }
        }
        else {
            echo 'ERROR 404!';
        }
    }
    else {
        echo 'ERROR 404!';
    }
}


/*
if (count($uri) == 4) {
    echo 'You are at the home page!';
}
elseif (count($uri) == 5) {

    if (is_readable($contPath . $uri[4] . $contExt)) {
        echo 'Please specify a function!';
    }
    else {
        echo 'Page does not exist';
    }
}
elseif (count($uri) == 6) {

    if (is_readable($contPath . $uri[4] . $contExt)) {

        if (method_exists($uri[4], $uri[5])) {
            $obj = new $uri[4]();
            $obj->$uri[5]();
        }
        else {
            echo 'Function does not exist!';
        }
    }
    else {
        echo 'Page does not exist, try another one!';
    }
}
*/
?>