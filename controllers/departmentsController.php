<?php

class departmentsController extends baseController {

    public function __construct() {
        if (!$this->checkUserAuth()) {
            //TODO - redirect to start page
        }
    }

    public function indexAction() {

        if ($this->checkUserAuth()) {
            //TODO - Show department view and get unanswered querys/replys, answered querys/replys, department admins, department visitors
        }
    }


    //Get values from database functions
    public function getDepartmentAdmins($dep) {
        //TODO - Get all users that are included in a department (get department id from get)
    }

    public function getDepartmentVisitors($dep) {
        //TODO - Get all visitors in a department (get department id from get)
    }

    public function getAnsweredQuerys($dep) {
        //TODO - get department querys including the replys
    }

    public function getUnansweredQuerys($dep) {
        //TODO - get unanswered querys including the replys
    }


    //Display functions
    public function displayDepNotification() {

        if ($this->checkUserAuth()) {

            if ($this->checkUserDep($_SESSION['user_id'])) {
                //TODO - Display notification to admins if there is an unanswered message in the department
            }
        }
    }

    public function displayDep() {

        if ($this->checkUserAuth()) {
            //TODO - Display department.php
        }
    }


    //Create functions
    public function createDepAction() {

        if ($this->checkAdminAuth()) {
            //TODO - Create a department (get department id from POST)
        }
    }

    public function createQueryAction() {

        if ($this->checkUserAuth()) {
            //TODO - Create a query (get values from POST)
        }
    }

    public function createReplyAction() {

        if ($this->checkUserAuth()) {
            //TODO - Check if the user that tries to reply are included in the department and create a reply (get values from POST)
        }
    }


    //Deactivate/delete function
    public function deactivateDepAction() {

        if ($this->checkAdminAuth()) {
            //TODO - Deactivate a department (get department id from POST)
        }
    }

    public function deleteQueryAction() {

        if ($this->checkUserAuth()) {
            //TODO - Check if the user are included in the department or the query owner, delete the query from the db (get query id from POST)
        }
    }

    public function deleteReplyAction() {

        if ($this->checkUserAuth()) {
            //TODO - Check if the user are included in the department, delete the reply from the db (get query id from POST)
        }
    }


    //Reactivate functions
    public function reactivateDepAction () {

        if ($this->checkAdminAuth()) {
            //TODO - Re-activate department (get department id from POST)
        }
    }

    public function reactiveUserAction() {
        if ($this->checkAdminAuth()) {
            //TODO - Re-activate a user (get user id from POST)
        }
    }


    //Check functions
    public function checkUserDep($dep) {
        //TODO - Check which department the current user belongs to
    }

    public function checkQueryOwner($query) {
        //TODO - Check who owns the query
    }
}