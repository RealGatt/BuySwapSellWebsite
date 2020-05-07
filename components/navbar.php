<nav class="navbar navbar-expand-lg navbar-dark primary-color">
    <!-- Navbar brand -->
    <a class="navbar-brand" href="/"><img src="assets/images/favicon.png" style="width:32px; height:32px;" alt="Book Trader"></a>

    <!-- Collapse button -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#basicNav" aria-controls="basicNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Collapsible content -->
    <div class="collapse navbar-collapse" id="basicNav">

        <ul class="navbar-nav mr-auto">

            <li class="nav-item">
                <a class="nav-link" href="/">Home</a>
            </li>

            <?php
            if (!isLoggedIn()) {
            ?>
                <li class="nav-item">
                    <a class="nav-link" href="/login.php">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/register.php">Register</a>
                </li>
            <?php
            } else {
            ?>
                <li class="nav-item">
                    <a class="nav-link" href="/profile.php">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/newlisting.php">Create Listing</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/logout.php">Logout</a>
                </li>
            <?php
            }
            ?>


            <!-- Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Search by Degree</a>
                <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="#">Bachelor of Information Technology</a>
                    <a class="dropdown-item" href="#">Bachelor of Nursing</a>
                    <a class="dropdown-item" href="#">Bachelor of Education</a>
                </div>
            </li>

        </ul>
        <!-- Links -->

        <?php

        if (isLoggedIn()) {
        ?>
            <span style="color:white;">Welcome back, <?= $_SESSION["userData"]->USER_NAME ?></span>
        <?php
        }
        ?>

        <form class="form-inline" action="/search.php" method="get">
            <div class="md-form my-0">
                <input class="form-control mr-sm-2" type="text" name="term" placeholder="Search" aria-label="Search">
            </div>
        </form>
    </div>
    <!-- Collapsible content -->

</nav>
<!--/.Navbar-->