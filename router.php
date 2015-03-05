<?php
//test
class Router {

    private $controller = 'startController';
    private $action = 'indexAction';

    private $path;
    private $uri;
    private $script;

    public function __construct() {
        $this->uri = explode(DIRECTORY_SEPARATOR, parse_url(strtolower(rtrim($_SERVER['REQUEST_URI'], DIRECTORY_SEPARATOR)), PHP_URL_PATH));
        $this->script = explode(DIRECTORY_SEPARATOR, parse_url(strtolower(rtrim($_SERVER['SCRIPT_NAME'], DIRECTORY_SEPARATOR)), PHP_URL_PATH));

        $this->getPath();
        if (count($this->path) <= 2) {
            $this->checkExistence();
        }
        else {
            echo 'TO MANY PARAMETERS!';
        }
    }

    public function getPath() {

        for ($i = 0; $i < count($this->script); $i++) {
            if (isset($this->uri[$i]) && $this->uri[$i] == $this->script[$i]) {
                unset($this->uri[$i]);
            }
        }

        $this->path = array_values($this->uri);
    }

    public function checkExistence() {
        $controller = $this->controller;
        $action = $this->action;

        if (!empty($this->path[0])) {
            $controller = $this->path[0] . 'Controller';

            if (!empty($this->path[1])) {
                $action = $this->path[1] . 'Action';
            }
        }

        if (is_readable('./controllers/' . $controller . '.php')) {
            $this->controller = $controller;

            if (method_exists($controller, $action)) {
                $this->action = $action;
            }
            else {
                $this->redirectToIndex();
            }
        }
        else {
            $this->redirectToIndex();
        }
    }

    public function getController() {
        return $this->controller;
    }

    public function getAction() {
        return $this->action;
    }

    public function redirectToIndex() {
        header('location:/PHP/GOD');
    }
}