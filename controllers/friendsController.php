<?php

class friendsController {
    public function connect_db(){
        $db = new PDO("mysql:host=localhost;dbname=sonet_db;charset=utf8", "root", "");
        return $db;
    }

    public function checkAuth() {
        if(!empty($_SESSION['status'])){
            return true;
        }
        else{
            return false;
        }
    }

    public function sendFriendRequestAction() {
        $db = $this->connect_db();
        $stm_check = $db->prepare("SELECT * FROM friendships WHERE (user_one_id = :one_id AND user_two_id = :two_id) OR (user_two_id = :one_id AND user_one_id = :two_id)");
        $stm_check->execute(array(
            ":one_id" => $_SESSION["user_id"],
            ":two_id" => $_POST["u_id"]
        ));

        if($stm_check->rowCount() == 0){
            $stm = $db->prepare("INSERT INTO friendships (user_one_id, user_two_id, user_action_id) VALUES (:one_id, :two_id, :action_id)");
            $result = $stm->execute(array(
                ":one_id" => $_SESSION["user_id"],
                ":two_id" => $_POST["u_id"],
                ":action_id" => $_SESSION["user_id"]
            ));
            if(isset($_POST['userlist']) == 1){
                header("location:/php/sonet/user/getUsers");
            }
            else{
            header("location:/php/sonet/user?user_id={$_POST['u_id']}");
            }
        }
        else{
            echo"friends";
        }
    }

    public function indexAction() {
        $db = $this->connect_db();
        $stm = $db->prepare("SELECT * FROM users WHERE users.user_id = :u_id");

        if(isset($_GET["user_id"])){
            $stm->bindParam(":u_id", $_GET["user_id"]);
        }
        else{
            $stm->bindParam(":u_id", $_SESSION["user_id"]);
        }

        if($stm->execute()){
            $obj = new friendsController();
            $check_friendship_data = $obj->checkFriendship();
            $obj2 = new friendsController();
            $friends_statuses_data = $obj2->getFriendsStatuses();
            $user_data = $stm->fetchAll(PDO::FETCH_ASSOC);
        }
        else{
            //TODO change to proper eror page
            echo "ERROR!";
        }
        $db = $this->connect_db();
        $stm = $db->prepare("
            SELECT f_name, l_name, profile_img, friendship, user_action_id, friends_list.friend_id
            from(
                SELECT
                    a.user_two_id AS friend_id,
                    a.friendship AS friendship,
                    a.user_action_id AS user_action_id
                FROM friendships a WHERE a.user_one_id= :u_one_id
                UNION
                SELECT
                    b.user_one_id AS friend_id,
                    b.friendship AS friendship,
                    b.user_action_id AS user_action_id
                FROM friendships b WHERE b.user_two_id= :u_two_id
            )friends_list
            JOIN users u ON u.user_id = friends_list.friend_id
            ORDER BY friendship desc, f_name asc;
        ");
        if(isset($_GET["user_id"])){
            $stm->bindParam(":u_one_id", $_GET["user_id"]);
            $stm->bindParam(":u_two_id", $_GET["user_id"]);
        }
        else{
            $stm->bindParam(":u_one_id", $_SESSION["user_id"]);
            $stm->bindParam(":u_two_id", $_SESSION["user_id"]);
        }
        if($stm->execute()){

            $friends_data = $stm->fetchAll(PDO::FETCH_ASSOC);
            require_once './views/friends.php';

        }
        else{
            echo "hej";
        }
    }

    public function acceptFriendRequestAction() {
        $db = $this->connect_db();
        $stm=$db->prepare("UPDATE friendships SET friendship = 1
            WHERE (user_one_id= :u_id AND user_two_id = :s_id) OR (user_one_id = :s_id AND user_two_id = :u_id)");
        $result = $stm->execute(array(
            ":s_id" => $_POST["this_user_id"],
            ":u_id" => $_SESSION["user_id"]
        ));
        if($result){
            header("location:/php/sonet/friends");
        }
        else{
            //TODO - fel nä det skulle skickas till db
        }
    }

    public function declineFriendRequestAction() {
        $db = $this->connect_db();
        $stm=$db->prepare("DELETE FROM friendships
            WHERE (user_one_id= :u_id AND user_two_id = :s_id) OR (user_one_id = :s_id AND user_two_id = :u_id)");
        $result = $stm->execute(array(
            ":s_id" => $_POST["this_user_id"],
            ":u_id" => $_SESSION["user_id"]
        ));
        if($result){
            header("location:/php/sonet/friends");
        }
        else{
            //TODO - fel nä det skulle skickas till db
        }
    }

    public function removeFriendAction() {
        $db = $this->connect_db();
        $stm=$db->prepare("DELETE FROM friendships
            WHERE (user_one_id = :u_id AND user_two_id = :s_id) OR (user_one_id = :s_id AND user_two_id = :u_id)");
        $result = $stm->execute(array(
            ":s_id" => $_POST["this_user_id"],
            ":u_id" => $_SESSION["user_id"]
        ));
        if($result){
            header("location:/php/sonet/friends");
        }
        else{
            //TODO - fel nä det skulle skickas till db
        }
    }

    public function getFriendsStatuses(){
        $db = $this->connect_db();
        $stm = $db->prepare("
            SELECT
            u.f_name,
            u.l_name,
            u.profile_img,
            friends_list.friendship,
            friends_list.friend_id,
            s.statusline,
            s.status_created_at
            from(
                SELECT
                    a.user_two_id AS friend_id,
                    a.friendship AS friendship
                FROM friendships a WHERE a.user_one_id= :u_id
                UNION
                SELECT
                    b.user_one_id AS friend_id,
                    b.friendship AS friendship
                FROM friendships b WHERE b.user_two_id= :u_id
                UNION
                SELECT
                    d.user_id AS friend_id,
                    d.user_id AS friendship
                FROM users d WHERE d.user_id= :u_id
            )friends_list
            JOIN users u ON u.user_id = friends_list.friend_id
            JOIN statuses s ON s.user_id = friends_list.friend_id
            ORDER BY s.status_created_at DESC
        ");
        $result = $stm->execute(array(
            ":u_id" => $_SESSION["user_id"]
        ));

        $friends_statuses_data = $stm->fetchAll(PDO::FETCH_ASSOC);
        return $friends_statuses_data;
    }

    public function checkFriendship(){
        $db = $this->connect_db();
        $stm = $db->prepare("
            SELECT friendship, user_action_id, friends_list.friend_id
            from(
                SELECT
                    a.user_two_id AS friend_id,
                    a.friendship AS friendship,
                    a.user_action_id AS user_action_id
                FROM friendships a WHERE a.user_one_id= :u_id
                UNION
                SELECT
                    b.user_one_id AS friend_id,
                    b.friendship AS friendship,
                    b.user_action_id AS user_action_id
                FROM friendships b WHERE b.user_two_id= :u_id
            )friends_list
            ");

        $result = $stm->execute(array(
            ":u_id" => $_SESSION["user_id"]
        ));

        $check_friendship_data = $stm->fetchAll(PDO::FETCH_ASSOC);
        return $check_friendship_data;
    }
}

