<?php
class baseController{

public function connect_db(){
    $db = new PDO("mysql:host=localhost;dbname=sonet_db;charset=utf8", "root", "");
    return $db;
}
}