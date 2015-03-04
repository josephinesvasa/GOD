<?php

class UserController extends BaseController {

    public function __construct() {
        if (!$this->checkUserAuth()) {
            header('location:/PHP/GOD');
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
        //TODO - Update current users name
    }

    public function updateImage() {
        //TODO - Update current users profile image
    }


    //Get functions
    public function getUser() {
        //TODO - Get a user from db
    }

    public function getRoomsAction() {
        //TODO - get all rooms that a user belongs to
        echo 'GET ALL ROOMS A USER BELONGS TO!';
    }

    public function getUserSettingsAction() {
        //TODO - Get a users settings
    }
}