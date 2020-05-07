<?php
include_once("components/header.php");
session_destroy();
$_SESSION["notification"] = "Successfully logged out";

header("Location: /");

?>