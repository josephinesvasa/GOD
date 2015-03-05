<?php
//test
abstract class BaseController {

    public function connect_db() {
        //TODO - connect to DATA BASE
    }

    public function checkUserAuth() {
        if (isset($_SESSION['auth'])) {
            if ($_SESSION['auth'] === 'user' || 'admin') {
                return true;
            }
        }
    }

    public function checkAdminAuth() {
        if (isset($_SESSION['auth'])) {
            if ($_SESSION['auth'] === 'admin') {
                return true;
            }
        }
    }
}