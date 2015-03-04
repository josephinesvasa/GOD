<?php

class AdminController extends UserController {

    public function __construct() {
        if (!$this->checkAdminAuth()) {
            header('location:/PHP/GOD');
        }
    }

    public function indexAction() {

        if ($this->checkAdminAuth()) {
            //TODO - Get admin view, active users, active departments, deactivated users, deactivated departments
            echo 'Get admin view, active users, active departments, deactivated users, deactivated departments';
        }
    }


    //Display functions
    public function displayAdmin() {
        //TODO - require admin.php
    }


    //Create functions
    public function createDepAction() {

        if ($this->checkAdminAuth()) {
            //TODO - Create a department (get dep info from POST)
        }
    }

    public function createUserAction() {

        if ($this->checkAdminAuth()) {
            //TODO - create a user (get info from POST)
        }
    }

    //Update functions
    public function updateDepAction() {

        if ($this->checkAdminAuth()) {
            //TODO - update department (get dep info from POST)
        }
    }

    public function updateUserAction() {

        if ($this->checkAdminAuth()) {
            //TODO - update user (get info from POST)
        }
    }

    //Deactivate functions
    public function deactivateDepAction() {

        if ($this->checkAdminAuth()) {
            //TODO - Deactivate department (get dep id from POST)
        }
    }

    public function deactivateUsersAction() {

        if ($this->checkAdminAuth()) {
            //TODO - Deactivate a user (get user id from POST)
        }
    }


    //Add functions
    public function addUsersToDepAction() {

        if ($this->checkAdminAuth()) {
            //TODO - add users to a department (get users from POST)
        }
    }


    //Remove functions
    public function removeUsersFromDepAction() {

        if ($this->checkAdminAuth()) {
            //TODO - Remove users from a department (get users from POST)
        }
    }
}