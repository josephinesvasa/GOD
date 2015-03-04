<?php

class startController {
    public function connect_db(){
        $db = new PDO("mysql:host=localhost;dbname=sonet_db;charset=utf8", "root", "");
        return $db;
    }

    public function checkAuth() {
        if(!empty($_SESSION['status'])){
            return true;
        }
        else{
            return false;
        }
    }

    public function indexAction() {
        if($this->checkAuth()){
            $obj = new friendsController();
            $friends_statuses_data = $obj->getFriendsStatuses();
            require_once './views/wall.php';
        }
        else{
            require_once './views/login.php';
        }
    }
}