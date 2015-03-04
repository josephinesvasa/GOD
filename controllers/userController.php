<?php

class userController extends baseController {

    public function __construct() {
        if (!$this->checkUserAuth()) {
            //TODO - Redirect to start page
        }
    }


    public function logIn() {
        //TODO - make login
    }

    public function logOut() {
        session_destroy();
        header( 'location: PHP/GOD/router.php' );
    }


    //Update functions
    public function updateName() {

        if ($this->checkUserAuth()) {
            //TODO - Update current users name
        }
    }

    public function updateImage() {

        if ($this->checkUserAuth()) {
            //TODO - Update current users profile image
        }
    }


    //Get functions
    public function getUser() {

        if ($this->checkUserAuth()) {
            //TODO - Get a user from db
        }
    }

    public function getRoomsAction() {

        if ($this->checkUserAuth()) {
            //TODO - get all rooms that a user belongs to
        }
    }

    public function getUserSettingsAction() {

        if ($this->checkUserAuth()) {
            //TODO - Get a users settings
        }
    }
}