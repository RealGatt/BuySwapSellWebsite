<?php

include_once("backend.php");

if (!isset($_SESSION)){
	session_start();
}

DEFINE("DB_DATABASE", ##);
DEFINE("DB_USER", ##);
DEFINE("DB_PASSWORD", ##); // super dooper unsecure, but meh.

class User{

    function __construct($name, $email, $loc)
    {
        $this->USER_NAME = $name;
        $this->USER_EMAIL = $email;
        $this->USER_LOCATION = $loc;
    }

    public $USER_ID;
    public $USER_NAME;
    public $USER_EMAIL;
    public $USER_LOCATION;
    public $USER_HASHEDPASSWORD;

}

function getAllUsers(){
	$returnArray =  array();
	$conn = new mysqli("localhost:3306", DB_USER, DB_PASSWORD, DB_DATABASE);
    
	$stmt = $conn->prepare("SELECT * from user;");
    
    $stmt->execute();

    $result = $stmt->get_result();

	mysqli_close($conn);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			array_push($returnArray, $row);
		}
	}
	return $returnArray;
}

function getUserForID($id){
    if (isset($id)){

        $conn = new mysqli("localhost:3306", DB_USER, DB_PASSWORD, DB_DATABASE);
        
        // prepare a new statement - stops sql injection
        $stmt = $conn->prepare("SELECT * from user WHERE id=?;");
        $stmt->bind_param("i", $id);
        
        $stmt->execute();

        $result = $stmt->get_result();
        
        mysqli_close($conn);
        
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				if ($row['id'] == $id){
                    $usr = new User($row["name"], $row["email"], $row["location"]);

                    $usr->USER_ID = $row["id"];
                    $usr->USER_HASHEDPASSWORD = $row["password"]; // create new user instance to return

                    return $usr;
				}
			}
        }
        
		return null;
	}
	return null;
}

function getUser($email=null){
	if (isset($email)){

        $email = strip_unsafe($email);

        $conn = new mysqli("localhost:3306", DB_USER, DB_PASSWORD, DB_DATABASE);
        
        // prepare a new statement - stops sql injection
        $stmt = $conn->prepare("SELECT * from user WHERE email=?;");
        $stmt->bind_param("s", $email);
        
        $stmt->execute();

        $result = $stmt->get_result();
        
        mysqli_close($conn);
        
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				if ($row['email'] == $email){
                    $usr = new User($row["name"], $row["email"], $row["location"]);

                    $usr->USER_ID = $row["id"];
                    $usr->USER_HASHEDPASSWORD = $row["password"]; // create new user instance to return

                    return $usr;
				}
			}
        }
        
		return null;
	}
	return null;
}

function userExists($email=null){
	if (isset($email)){
        $user = getUser($email);
        return !($user == null);
	}
	return true; // make sure you can't create "null" accounts
}

function createUser($fullname=null, $password=null, $email=null, $location=null){
	if (isset($fullname) && isset($password) && isset($email) && isset($location)){
		if (!userExists($email)){
			if (strlen($password) <= 5){
				return "ERROR: Password too short. Passwords have to be at least 6 characters";
            }
                        
            $fullname = strip_unsafe($fullname);
            $email = strip_unsafe($email);
            $location = strip_unsafe($location);

			$options = array(
				'cost' => 12 // High = more secure. Minimum should be 10.
            );

            $pw = password_hash($password, PASSWORD_BCRYPT, $options);

			$conn = new mysqli("localhost:3306", DB_USER, DB_PASSWORD, DB_DATABASE);
            $stmt = $conn->prepare("INSERT INTO `user` (`name`, `email`, `password`, `location`) VALUES (?, ?, ?, ?);");
            
            $stmt->bind_param("ssss", $fullname, $email, $pw, $location);

            $success = $stmt->execute();
            
            mysqli_close($conn);

            return $success ? "created" : "Database Error";
		}
		return "User Exists";
	}
	return "Invalid Response";
}

function attemptLogin($email, $password){
    if (isset($email) && isset($password)){

        $email = strip_unsafe($email);

        $usr = getUser($email);


        if ($usr != null){
            return password_verify($password, $usr->USER_HASHEDPASSWORD) ? "success" : "wrong password";
        }

        return "no user";
    }
}

function isLoggedIn(){
    return isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"];
}

?>