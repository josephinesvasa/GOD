<?php

class StartController extends BaseController {

    public function indexAction() {

        if ($this->checkUserAuth()) {
            echo 'You are now logged in!';
        }
        else {
            echo 'You need to login';
        }
    }
}