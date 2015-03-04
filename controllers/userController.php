<?php

class userController {
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

    public function loginAction() {
        $db = $this->connect_db();
        if(!empty($_POST["email"]) && !empty($_POST["password"])){
            $stm = $db->prepare("SELECT * FROM users WHERE email = :email");
            $stm->bindParam(":email", $_POST["email"]);
            $stm->execute();
            $result = $stm->fetchAll(PDO::FETCH_ASSOC);
            foreach($result as $row){
                $hash = $row['password'];
                if (password_verify($_POST['password'], $hash)) {
                    $_SESSION['status'] = 'online';
                    $_SESSION['user_id'] = $row['user_id'];
                    $_SESSION['f_name'] = $row['f_name'];
                    $_SESSION['l_name'] = $row['l_name'];
                    $_SESSION['profile_img'] = $row['profile_img'];
                    header("location:/php/sonet");
                }
                else {
                    header("location:/php/sonet?msg=Wrong password");
                }
            }
        }
        else{
            header("location:/php/sonet?msg=Wrong e-mail");
        }
    }

    public function logoutAction() {
        session_unset();
        session_destroy();
        header("location:/php/sonet");
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

        $db = $this->connect_db();
        $stm_status = $db->prepare("SELECT * FROM statuses WHERE user_id = :u_id ORDER BY status_created_at desc ");

        if(isset($_GET["user_id"])){
            $stm_status->bindParam(":u_id", $_GET["user_id"]);
        }
        else{
            $stm_status->bindParam(":u_id", $_SESSION["user_id"]);
        }

        if($stm->execute() && $stm_status->execute()){
            $obj = new friendsController();
            $check_friendship_data = $obj->checkFriendship();
            $user_data = $stm->fetchAll(PDO::FETCH_ASSOC);
            $status_data = $stm_status->fetchAll(PDO::FETCH_ASSOC);
            require_once './views/user.php';

        }
        else{
            //TODO change to proper eror page
            echo "ERROR!";
        }
    }

    public function getUsersAction() {
        $db = $this->connect_db();
        $stm = $db->prepare("SELECT user_id, profile_img, f_name, l_name FROM users
            WHERE user_id != :u_id
            ORDER BY f_name asc");
        $result = $stm->execute(array(
            ":u_id" => $_SESSION["user_id"]
        ));

        $obj = new friendsController();
        $check_friendship_data = $obj->checkFriendship();
        $friends_data = $stm->fetchAll(PDO::FETCH_ASSOC);
        require_once './views/userlist.php';
    }

    public function checkIfUserExist($user_id) {
        $db = $this->connect_db();
        $stm = $db->prepare("SELECT * FROM users WHERE user_id = :user_id");

        $stm->bindParam(':user_id', $user_id, PDO::PARAM_INT);

        if ($stm->execute()) {
            $user = $stm->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($user)) {
                return true;
            }
            else {
                echo 'The user does not exist!';
            }
        }
        else {
            echo 'Could not execute checkIfUserExist function!';
        }
    }

    public function getSettingsAction() {

        if ($this->checkIfUserExist($_SESSION['user_id'])) {

            $db = $this->connect_db();

            $stm = $db->prepare("
                SELECT
                    f_name,
                    l_name,
                    city
                FROM
                    users
                WHERE
                    user_id = :user_id
            ");

            $stm->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);

            if ($stm->execute()) {
                $user_info = $stm->fetchAll(PDO::FETCH_ASSOC);
            }

            require_once './views/settings.php';
        }
        else {

        }
    }

    public function updateStatusAction() {
        if(!empty($_POST["status"])){
            $db = $this->connect_db();
            $stm=$db->prepare("INSERT INTO statuses (statusline, user_id ) VALUES (:st_line, :u_id)");
            $result = $stm->execute(array(
                ":st_line" => $_POST["status"],
                ":u_id" => $_SESSION["user_id"]
            ));
            if($result){
                header("location:/php/sonet");
            }
            else{
                header("location:/php/sonet");
            }
        }
        else{
            header("location:/php/sonet");
        }
    }

    public function checkPassword($pass) {
        $db = $this->connect_db();

        $stm = $db->prepare("SELECT * FROM users WHERE user_id = :user_id");
        $stm->bindParam(":user_id", $_SESSION['user_id']);

        if ($stm->execute()) {
            $result = $stm->fetchAll(PDO::FETCH_ASSOC);
            foreach($result as $row){
                $hash = $row['password'];
                if (password_verify($pass, $hash)) {
                    return true;
                }
                else {
                    return false;
                }
            }
        }
    }

    public function updateFirstName($fname) {
        $db = $this->connect_db();

        $stm = $db->prepare("
            UPDATE users SET f_name = :f_name WHERE user_id = :user_id
        ");

        $stm->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stm->bindParam(':f_name', $fname);

        if ($stm->execute()) {
            $_SESSION['f_name'] = $fname;
        }
        else {
            echo 'Could not update first name!';
        }
    }

    public function updateLastName($lname) {
        $db = $this->connect_db();

        $stm = $db->prepare("
            UPDATE users SET l_name = :l_name WHERE user_id = :user_id
        ");

        $stm->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stm->bindParam(':l_name', $lname);

        if (!$stm->execute()) {
            echo 'Could not update last name!';
        }
    }

    public function updateCity($city) {
        $db = $this->connect_db();

        $stm = $db->prepare("
            UPDATE users SET city = :city WHERE user_id = :user_id
        ");

        $stm->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stm->bindParam(':city', $city);

        if (!$stm->execute()) {
            echo 'Could not update city!';
        }
    }

    public function updateUserInfoAction() {
        if (isset($_POST['updateUserInfo'])) {

            if (!empty($_POST['password'])) {

                if ($this->checkPassword($_POST['password'])) {

                    if (array_filter($_POST)) {
                        if (!empty($_POST['f_name'])) {
                            $this->updateFirstName($_POST['f_name']);
                        }

                        if (!empty($_POST['l_name'])) {
                            $this->updateLastName($_POST['l_name'], $_POST['password']);
                        }

                        if (!empty($_POST['city'])) {
                            $this->updateCity($_POST['city'], $_POST['password']);
                        }

                        header('location:/PHP/Sonet/user/getSettings');

                    } else {
                        header('location:/PHP/Sonet/user/getSettings');
                    }
                }
                else {
                    header('location:/PHP/Sonet/user/getSettings');
                }
            }
            else {
                header('location:/PHP/Sonet/user/getSettings');
            }
        }
    }

    public function updatePasswordAction() {
        $db = $this->connect_db();
        if(!empty($_POST["old_password"])){
            $stm = $db->prepare("SELECT * FROM users WHERE user_id = :u_id");
            $stm->bindParam(":u_id", $_SESSION["user_id"]);
            $stm->execute();
            $result = $stm->fetchAll(PDO::FETCH_ASSOC);
            foreach($result as $row){
                $hash = $row['password'];
                if (password_verify($_POST['old_password'], $hash)) {
                    if(!empty($_POST["new_password"]) && !empty($_POST["rw_password"])){
                        if(($_POST["new_password"] == $_POST["rw_password"]) && (strlen($_POST["new_password"]) >= 6)){
                            $hashPass = password_hash($_POST["new_password"], PASSWORD_BCRYPT, array("cost" => 11));
                            $stm =$db->prepare("UPDATE users SET  password = :pass WHERE user_id = :u_id");
                            $result = $stm->execute(array(
                                ":u_id" => $_SESSION["user_id"],
                                ":pass" => $hashPass
                            ));
                            if($result){
                                header("location:/php/sonet/user/getSettings?msg=ditt lösen är uppd");
                            }
                            else{
                                header("location:/php/sonet/user/getSettings?msg=fel pass");
                            }
                        }
                    }
                    else{
                        header("location:/php/sonet/user/getSettings?msg=fel ifyllt");
                    }
                }
                else{
                    header("location:/php/sonet/user/getSettings?msg=no match");
                }
            }
        }
        else{
            header("location:/php/sonet/user/getSettings?msg=missing old pass");
        }
    }

    public function createAction() {
        $db = $this->connect_db();
        if(!empty($_POST["f_name"]) && !empty($_POST["l_name"]) && !empty($_POST["city"]) && !empty($_POST["email"]) && !empty($_POST["password"]) && !empty($_POST["rw_password"])){
            if(($_POST["password"] == $_POST["rw_password"]) && (strlen($_POST["password"]) >= 6)){

                if(filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
                    $hashPass = password_hash($_POST["password"], PASSWORD_BCRYPT, array("cost" => 11));

                    $stm = $db->prepare("INSERT INTO users (f_name, l_name, city, email, password) VALUES (:f_name, :l_name, :city, :email, :pass)");
                    $result = $stm->execute(array(
                        ":f_name" => $_POST["f_name"],
                        ":l_name" => $_POST["l_name"],
                        ":city" => $_POST["city"],
                        ":email" => $_POST["email"],
                        ":pass" => $hashPass
                    ));

                    if($result){
                        header("location:/php/sonet");
                    }
                    else{
                        header("location:/php/sonet?msg=test2");
                    }
                }
                else{
                    header("location:/php/sonet?msg=test3");
                }
            }
            else{
                header("location:/php/sonet?msg=test4");
            }
        }
        else{
            header("location:/php/sonet?msg=test5");
        }
    }

    public function deactivateAction() {
        $db = $this->connect_db();
        $stm = $db->prepare("UPDATE users SET active_account = 0 WHERE users.user_id = :u_id");
        $result = $stm->execute(array(
            ":u_id" => $_SESSION["user_id"]
        ));
        if($result){
            $obj = new userController();
            $obj->logoutAction();
        }
        else{
            //TODO - vad ska stå när kontot är deaktiverat?
        }
    }
}
