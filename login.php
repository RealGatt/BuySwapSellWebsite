<?php
    include_once("api/userapi.php");
    if (isset($_POST["accountEmail"]) && isset($_POST["accountPassword"])){
        $loginAttempt = attemptLogin($_POST["accountEmail"], $_POST["accountPassword"]);
        if ($loginAttempt == "success"){
            $usr = getUser($_POST["accountEmail"]);
            $_SESSION["loggedIn"] = "true";
            $_SESSION["email"] = $_POST["accountEmail"];
            $_SESSION["userID"] = $usr->USER_ID;
            $_SESSION["userData"] = $usr;

            $_SESSION["notification"] = "Successfully logged in as ".$usr->USER_NAME;

            header("Location: /");
            return;
        }else{
            $_SESSION["notification"] = "Failed to login. Perhaps an incorrect password?";
        }
    }

    $title = "Login";
    include_once("components/header.php");
?>

<body>
    <?php 
    include_once("components/navbar.php"); 
    ?>
    <div class="content">
        <?php include_once("components/notification.php"); ?>
        <form class="text-center border border-light p-5" action="/login.php" method="post">
            <p class="h4 mb-4">Sign in</p>
            <!-- Email -->
            <input type="email" id="accountEmail" name="accountEmail"  class="form-control mb-4" placeholder="Email" required>

            <!-- Password -->
            <input type="password" id="accountPassword" name="accountPassword" class="form-control mb-4" placeholder="Password" required>

            <div class="d-flex justify-content-around">
                <div>
                    <!-- Forgot password -->
                    <a onclick="alert('Too bad.'); return false">Forgot password?</a>
                </div>
            </div>
            <!-- Sign in button -->
            <button class="btn btn-info btn-block my-4" type="submit">Sign in</button>
        </form>
    </div>
</body>