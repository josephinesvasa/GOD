<?php

abstract class baseController {
    protected  $db = PDO("mysql:host=localhost;dbname=sonet_db;charset=utf8", "root", "");

    public function connect_db() {
        //TODO - connect to DATA BASE
    }

    public function checkUserAuth() {
        //TODO - Check if the user has SESSION status "online"
    }

    public function checkAdminAuth() {
        //TODO - check if the user has SESSION admin "1"
    }
}