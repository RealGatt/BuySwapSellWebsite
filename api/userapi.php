<?php
session_start();

function isLoggedIn(){
    return array_key_exists("usertoken", $_SESSION) != null && $_SESSION["usertoken"] != null;
}

?>