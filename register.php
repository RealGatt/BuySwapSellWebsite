<?php
include_once("api/userapi.php");
if (
    isset($_POST["accountEmail"])
    && isset($_POST["accountName"]) && isset($_POST["location"])
    && isset($_POST["password"]) && isset($_POST["passwordConfirm"])
) {

    if ($_POST["password"] != $_POST["passwordConfirm"]) {
        $_SESSION["notification"] = "The two passwords didn't match! Try again!";
    } else {

        $createAttempt = createUser($_POST["accountName"], $_POST["password"], $_POST["accountEmail"], $_POST["location"]);
        if ($createAttempt == "created") {

            $usr = getUser($_POST["accountEmail"]);
            
            $_SESSION["loggedIn"] = "true";
            $_SESSION["email"] = $_POST["accountEmail"];
            $_SESSION["userID"] = $usr->USER_ID;
            $_SESSION["userData"] = $usr;

            $_SESSION["notification"] = "Successfully created account " . $usr->USER_NAME;

            header("Location: /");
            return;
        } else {
            $_SESSION["notification"] = "Failed to register: " . $createAttempt;
        }
    }
}

$title = "Register";
include_once("components/header.php");
?>

<body>
    <?php include_once("components/navbar.php"); ?>
    <div class="content">

        <?php include_once("components/notification.php"); ?>

        <form class="text-center border border-light p-5" action="/register.php" method="post">

            <p class="h4 mb-4">Sign up</p>

            <!-- Full Name -->
            <input type="text" id="accountName" name="accountName" class="form-control mb-4" placeholder="Full Name" required>
            <!-- Email -->
            <input type="email" id="accountEmail" name="accountEmail" class="form-control mb-4" placeholder="Email" required>

            <!-- Location -->
            <input type="text" id="location" name="location" class="form-control mb-4" placeholder="Your Location" required>

            <!-- Password -->
            <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
            <input type="password" id="passwordConfirm" name="passwordConfirm" class="form-control" placeholder="Confirm Password" required>

            <!-- Sign up button -->
            <button class="btn btn-info my-4 btn-block" type="submit">Sign up</button>
        </form>
    </div>
</body>