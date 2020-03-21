
<!-- Modals -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <form class="text-center border border-light p-5" action="/login.php">
            <p class="h4 mb-4">Sign in</p>
            <!-- Email -->
            <input type="email" id="defaultLoginFormEmail" class="form-control mb-4" placeholder="Email" required>

            <!-- Password -->
            <input type="password" id="defaultLoginFormPassword" class="form-control mb-4" placeholder="Password" required>

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
  </div>
</div>

<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <!-- Default form register -->
        <form class="text-center border border-light p-5" action="/register.php">

            <p class="h4 mb-4">Sign up</p>

            <div class="form-row mb-4">
                <div class="col">
                    <!-- First name -->
                    <input type="text" id="defaultRegisterFormFirstName" class="form-control" placeholder="First name" required>
                </div>
                <div class="col">
                    <!-- Last name -->
                    <input type="text" id="defaultRegisterFormLastName" class="form-control" placeholder="Last name" required>
                </div>
            </div>

            <!-- Email -->
            <input type="email" id="defaultRegisterFormEmail" class="form-control mb-4" placeholder="Email" required>

            <!-- Password -->
            <input type="password" id="defaultRegisterFormPassword" class="form-control" placeholder="Password" aria-describedby="defaultRegisterFormPasswordHelpBlock" required>
            <input type="password" id="defaultRegisterFormPasswordConfirmation" class="form-control" placeholder="Confirm Password" aria-describedby="defaultRegisterFormPasswordHelpBlock" required>

            <!-- Sign up button -->
            <button class="btn btn-info my-4 btn-block" type="submit">Sign up</button>
        </form>
    </div>
  </div>
</div>

<nav class="navbar navbar-expand-lg navbar-dark primary-color">
    <!-- Navbar brand -->
    <a class="navbar-brand" href="/"><img src="assets/images/favicon.png" style="width:32px; height:32px;" alt="Book Trader"></a>

    <!-- Collapse button -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#basicNav"
        aria-controls="basicNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Collapsible content -->
    <div class="collapse navbar-collapse" id="basicNav">

        <ul class="navbar-nav mr-auto">

            <li class="nav-item">
                <a class="nav-link" href="/">Home</a>
            </li>

            <?php
            if (!isLoggedIn()){
                ?>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="modal" data-target="#loginModal" onclick="return false;">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="modal" data-target="#registerModal" onclick="return false;">Register</a>
                </li>
                <?php
            }else{
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
                <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">Search by Degree</a>
                <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="#">Bachelor of Information Technology</a>
                <a class="dropdown-item" href="#">Bachelor of Nursing</a>
                <a class="dropdown-item" href="#">Bachelor of Education</a>
                </div>
            </li>

        </ul>
        <!-- Links -->

        <form class="form-inline" action="/search.php" method="get">
        <div class="md-form my-0">
            <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
        </div>
        </form>
    </div>
    <!-- Collapsible content -->

</nav>
<!--/.Navbar-->