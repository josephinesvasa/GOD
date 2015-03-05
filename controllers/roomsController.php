<?php
<<<<<<< HEAD
//test
class RoomsController extends BaseController {
=======

class RoomController extends baseController {
>>>>>>> origin/master

    public function __construct() {
        if (!$this->checkUserAuth()) {
            //TODO - redirect to start page
        }
    }


    public function indexAction() {
        //TODO - view room.php AND get room messages AND room users
    }

    //Create functions
    public function create() {
        //TODO - Create a room (get room name and users to add to the room from POST)
    }

    public function createMessageAction() {
        //TODO - Create a message (get info from post)
    }


    //Update functions
    public function updateNameAction() {
        //TODO - Edit room name (get room id from post)
    }


    //Delete functions
    public function deleteRoom() {
        //TODO - Delete a room (get room from post)
    }

    public function deleteMessageAction() {
        //TODO - Delete one of my own messages
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
        $stm = $this->$db->prepare("
        SELECT f_name, l_name FROM users AS u
        JOIN rooms_users AS ru ON ru.user_id = u.user_id
        WHERE ru.room_id = :room");
        //TODO - Get all users in a room if the room is public (get room id from GET)
    }

    public function getMessages($room) {
        //TODO - Get all messages that belong to a room (get room id from GET)
    }


    //Leave/hide function
    public function leaveGroupRoomAction() {
        //TODO - Remove the user from the room AND check if the user is alone in the room (if true, remove the room)
    }

    public function hidePrivateRoomAction() {
        //TODO - Hide a private room
    }


    //Redirect functions
    public function redirectToRoom() {
        //TODO - make a header location to room with id
    }


    //Display functions
    public function displayRoomNotification() {
        //TODO - Display notifications to users who don't have the current room as main window
    }

    public function displayRoom() {
        //TODO - Display room.php
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