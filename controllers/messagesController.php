<?php

class messagesController {
    public function connect_db(){
        $db = new PDO("mysql:host=localhost;dbname=sonet_db;charset=utf8", "root", "");
        return $db;
    }
    public function checkAuth() {
        if (!empty($_SESSION['status'])) {
            return true;
        }
        else {
            return false;
        }
    }

    public function createConversation() {
        $db = $this->connect_db();

        $createConv = $db->prepare("
                        INSERT INTO
                            conversations
                        (
                            conv_user_one_id,
                            conv_user_two_id
                        )
                        VALUES
                        (
                            :my_id,
                            :u_id
                        )
                    ");

        //TODO - call a function from users that check if the user exists in the database

        $createConv->bindParam(':my_id', $_SESSION['user_id'], PDO::PARAM_INT);
        $createConv->bindParam(':u_id', $_POST['u_id'], PDO::PARAM_INT);

        if ($createConv->execute()) {
            $this->sendMessageAction();
        }
        else {
            echo 'Could not create the conversation :(';
        }
    }

    public function sendMessageAction() {

        if ($this->checkAuth()) {
            $db = $this->connect_db();
            $stm = $db->prepare("
                SELECT
                    conversation_id AS c_id
                FROM
                    conversations
                WHERE
                    conv_user_one_id IN (:id, :my_id)
                AND
                    conv_user_two_id IN (:id, :my_id)
            ");

            $stm->bindParam(':id', $_POST['u_id']);
            $stm->bindParam(':my_id', $_SESSION['user_id']);

            if ($stm->execute()) {
                $conversation = $stm->fetchAll(PDO::FETCH_ASSOC);

                if (empty($conversation[0]['c_id'])) {
                    $this->createConversation();
                }

                $createMsg = $db->prepare("
                        INSERT INTO
                            messages
                        (
                            message,
                            writer_id,
                            conversation_id
                        )
                        VALUES
                        (
                            :msg,
                            :writer_id,
                            :c_id
                        )
                    ");

                $createMsg->bindParam(':msg', $_POST['msg']);
                $createMsg->bindParam(':writer_id', $_SESSION['user_id'], PDO::PARAM_INT);
                $createMsg->bindParam(':c_id', $conversation[0]['c_id'], PDO::PARAM_INT);

                if ($createMsg->execute()) {
                    header('location:/PHP/Sonet/messages/getConvMessages?u_id=' . $_POST['u_id']);
                }
                else {
                    echo 'This shit fukked up! :/';
                }
            }
        }
    }

    public function indexAction() {

        if ($this->checkAuth()) {

            $db = $this->connect_db();
            $stm = $db->prepare("
                SELECT
                    u.f_name,
                    u.l_name,
                    u.profile_img,
                    conv_user_list.user_id,
                    conv_user_list.conv_id AS conv_id,
                    (SELECT message FROM messages AS M WHERE M.conversation_id = conv_id ORDER BY created_at DESC LIMIT 0,1) AS last_msg,
                    (SELECT writer_id FROM messages AS M WHERE M.conversation_id = conv_id ORDER BY created_at DESC LIMIT 0,1) AS last_msg_writer
                FROM (
                    SELECT
                        a.conversation_id AS conv_id,
                        a.conv_user_two_id AS user_id
                    FROM conversations AS a WHERE a.conv_user_one_id= :u_id

                    UNION

                    SELECT
                        b.conversation_id AS conv_id,
                        b.conv_user_one_id AS user_id
                    FROM conversations AS b WHERE b.conv_user_two_id= :u_id
                )
                AS conv_user_list
                JOIN users AS u ON (u.user_id = conv_user_list.user_id)
            ");

            $stm->bindParam(':u_id', $_SESSION['user_id']);

            if ($stm->execute()) {
                $conversations = $stm->fetchAll(PDO::FETCH_ASSOC);
                require_once './views/inbox.php';
            }
        }
        else {
            header('location:/PHP/Sonet/');
        }
    }

    public function getConvMessagesAction() {

        $db = $this->connect_db();
        $stm = $db->prepare("
            SELECT
                cv.conv_user_one_id,
                cv.conv_user_two_id,
                m.message,
                m.writer_id,
                m.created_at
            FROM
                conversations AS cv
            JOIN
                messages AS m
            ON
                m.conversation_id = cv.conversation_id
            WHERE
                cv.conv_user_one_id IN (:my_id, :id) AND cv.conv_user_two_id IN (:my_id, :id)
            ORDER BY
                m.created_at DESC
        ");

        $stm2 = $db->prepare("
                    SELECT
                        f_name,
                        l_name,
                        profile_img,
                        user_id
                    FROM
                        users
                    WHERE
                        user_id IN (:id, :my_id)
                ");

        $stm->bindParam(':id', $_GET['u_id'], PDO::PARAM_INT);
        $stm->bindParam(':my_id', $_SESSION['user_id'], PDO::PARAM_INT);

        $stm2->bindParam(':id', $_GET['u_id'], PDO::PARAM_INT);
        $stm2->bindParam(':my_id', $_SESSION['user_id'], PDO::PARAM_INT);

        $convMessages = '';
        $convUsers = '';

        if ($stm->execute() && $stm2->execute()) {
            $convMessages = $stm->fetchAll(PDO::FETCH_ASSOC);
            $convUsers = $stm2->fetchAll(PDO::FETCH_ASSOC);

            $convUserInfo = array();
            $selfInfo = array();

            foreach($convUsers as $userKey => $userVal) {
                if ($userVal['user_id'] !== $_SESSION['user_id']) {
                    $convUserInfo = $userVal;
                }
                else {
                    $selfInfo = $userVal;
                }
            }
        }
        else {
            echo 'Naj du, dei gick int de naj! :(';
        }

        require_once './views/messages.php';
    }
}