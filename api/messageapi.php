<?php

include_once("userapi.php");
include_once("itemapi.php");

function sendMessage($SENDER, $OFFER, $MSG){
    $MSG = clean($MSG);
    $msgInstance = new Message();
    $msgInstance->SENDER = $SENDER;
    $msgInstance->OFFER_ID = $OFFER;
    $msgInstance->MESSAGE = $MSG;
    $_SESSION["notification"] = "Successfully send message";
    return $msgInstance->saveToDatabase();
}

function getMessagesForConversation($OFFER_ID){
    $messages = array();

    $conn = new mysqli("localhost:3306", DB_USER, DB_PASSWORD, DB_DATABASE);

    // prepare a new statement - stops sql injection
    $stmt = $conn->prepare("SELECT * from message WHERE offer_id=?;");
    $stmt->bind_param("s", $OFFER_ID);

    $stmt->execute();

    $result = $stmt->get_result();

    mysqli_close($conn);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($row['offer_id'] == $OFFER_ID) {
                $msg = new Message();
                $msg->MESSAGE_ID = $row["id"];
                $msg->SENDER = getUserForId($row["from_user_id"]);
                $msg->OFFER_ID = $row["offer_id"];
                $msg->TIME_SENT = $row["sent"];
                $msg->MESSAGE = $row["text"];
                array_push($messages, $msg); 
            }
        }
    }
    return $messages;
}

class Message{
    public $MESSAGE_ID = -1;
    public $SENDER;
    public $OFFER_ID;
    public $TIME_SENT;
    public $MESSAGE;

    function saveToDatabase()
    {
        $conn = new mysqli("localhost:3306", DB_USER, DB_PASSWORD, DB_DATABASE);
        if ($this->MESSAGE_ID < 0) { // new message
            try {
                $stmt = $conn->prepare("INSERT INTO message (from_user_id, offer_id, text)
                VALUES (?,?,?);");

                $stmt->bind_param(
                    "sss",
                    $this->SENDER->USER_ID,
                    $this->OFFER_ID,
                    $this->MESSAGE
                );

                $stmt->execute();

                $this->MESSAGE_ID = $conn->insert_id;
                return true;
            } catch (PDOException $e) {
                echo "<br>" . $e->getMessage();
            }
        }
    }

}
