<?php
session_start();

class User{

    function __construct($id, $name, $email, $loc)
    {
        $this->USER_ID = $id;
        $this->USER_NAME = $name;
        $this->USER_EMAIL = $email;
        $this->USER_LOCATION = $loc;
    }

    public $USER_ID;
    public $USER_NAME;
    public $USER_EMAIL;
    public $USER_LOCATION;

}


function isLoggedIn(){
    return array_key_exists("usertoken", $_SESSION) != null && $_SESSION["usertoken"] != null;
}

function getUserForID($id){
    switch ($id){
        case 1:
            return new User("1", "John Smith", "john.smith@apple.com", "TARDIS");
    }
    return null;
}

?>