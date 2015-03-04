<?php

class RoomController extends baseController {

    public function __construct() {
        if (!$this->checkUserAuth()) {
            //TODO - redirect to start page
        }
    }


    public function indexAction() {
        if ($this->checkUserAuth()) {
            //TODO - view room.php AND get room messages AND room users
        }
    }

    //Create functions
    public function create() {

        if ($this->checkUserAuth()) {
            //TODO - Create a room (get room name and users to add to the room from POST)
        }
    }

    public function createMessageAction() {

        if ($this->checkUserAuth()) {
            //TODO - Create a message (get info from post)
        }
    }


    //Update functions
    public function updateNameAction() {

        if ($this->checkUserAuth()) {
            //TODO - Edit room name (get room id from post)
        }
    }


    //Delete functions
    public function deleteRoom() {
            //TODO - Delete a room (get room from post)
    }

    public function deleteMessageAction() {

        if ($this->checkUserAuth()) {
            //TODO - Delete one of my own messages
        }
    }


    //Remove functions
    public function removeRoomNotification() {
        //TODO - Remove a notification from the current user when it clicks on the notified Room
    }

    public function removeUserAction() {
        //TODO - Remove a user from the room (get user id and room id from post)
    }


    //Add functions
    public function addUsersAction() {
        //TODO - add a user to a room (get user id and room id from POST)
    }


    //Get functions
    public function getUsers($room) {
        //TODO - Get all users in a room if the room is public (get room id from GET)
    }

    public function getMessages($room) {
        //TODO - Get all messages that belong to a room (get room id from GET)
    }

    public function getMessagesAction($room) {
        //TODO - Get all messages from a room (get room id from GET)
    }


    //Leave/hide function
    public function leaveGroupRoomAction() {

        if ($this->checkUserAuth()) {
            //TODO - Remove the user from the room AND check if the user is alone in the room (if true, remove the room)
        }
    }

    public function hidePrivateRoomAction() {

        if ($this->checkUserAuth()) {

        }
    }


    //Redirect functions
    public function redirectToRoom() {
        //TODO - make a header location to room with id
    }


    //Display functions
    public function displayRoomNotification() {

        if ($this->checkUserAuth()) {
            //TODO - Display notifications to users who don't have the current room as main window
        }
    }

    public function displayRoom() {

        if ($this->checkUserAuth()) {
            //TODO - Display room.php
        }
    }


    //Check functions
    public function checkRoomUsers($room) {
        //TODO - check how many users exist in a room
    }

    public function checkIfRoomExist($user) {
        //TODO - Check if the room the user wants to go to exist
    }

    public function checkIfUserExist($user) {
        //TODO - Check if a user exist
    }

    public function checkMessageOwner($msg) {
        //TODO - Check if the owner of the messages is the current user or not (get message id from POST)
    }
}