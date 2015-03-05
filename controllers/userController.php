<?php
<<<<<<< HEAD
//test
class UserController extends BaseController {
=======

class userController extends baseController {
>>>>>>> origin/master

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
    }

    public function getUserSettingsAction() {
        //TODO - Get a users settings
    }
}