<?php

class userController extends baseController {
    public function logIn() {
        //TODO - make login
    }

    public function logOut() {
        session_destroy();
        header( 'location: arbetsochprojektmetodik/lorenum/router.php' );
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

        }
        //TODO - Get user from db
    }

    public function getRoomsAction() {

        if ($this->checkUserAuth()) {
            //TODO -
        }
    }

    public function getUserSettings() {

    }
}