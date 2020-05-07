<?php
include_once("./api/itemapi.php");
include_once("./api/userapi.php");

if (!isLoggedIn()) {
    header("Location: /");
    die();
}

if (isset($_POST["submit"])){
    print_r($_POST);
    $slr = $_SESSION['userData'];

    $newItem = new Item($slr->USER_ID, -1, strip_unsafe($_POST['itemName']), 
    strip_unsafe($_POST['description']), 
    strip_unsafe($_POST['seeking']), "ACCEPTING_OFFERS", $_POST["condition"], $_POST["courses"], array());

    $newItem->saveToDatabase();
    header("Location: /item.php?id=".$newItem->ITEM_ID);
}


$title = "New Listing";

include_once("components/header.php");
?>


<body>
    <?php include_once("components/navbar.php"); ?>

    <div class="container" id="itemContainer">
        <form action="newlisting.php" id="newlisting" method="post">
            <div class="container my-5 py-5 z-depth-1">

                <input type="hidden" id="submit" name="submit" value="true">

                <!--Section: Content-->
                <section class="text-center">

                    <!-- Section heading -->
                    <h3 class="font-weight-bold mb-5">Create new Listing</h3>

                    <div class="row">

                        <div class="col-lg-6">

                            <span class="grey-text">Upload Image</span>

                            <div class="file-upload-wrapper">
                                <input type="file" id="item-image" class="file-upload" accept=".png,.jpg,.jpeg" onclick="alert('This doesn\'t do anything. Just imagine it working :)'); return false;"/>
                            </div>

                        </div>

                        <div class="col-lg-5 text-center text-md-left">

                            <h2 class="h2-responsive text-center text-md-left product-name font-weight-bold dark-grey-text mb-1 ml-xl-0 ml-4">
                                <strong><input type="text" name="itemName" id="itemName" placeholder="Item Name" required></strong>
                            </h2>
                            <span class="badge badge-danger product mb-4 ml-xl-0 ml-4"><input type="text" name="courses" id="courses" placeholder="Courses" required></span>
                            <h3 class="h3-responsive text-center text-md-left mb-5 ml-xl-0 ml-4">
                                <span class="font-weight-bold">
                                    <strong>Seeking: </strong>
                                    <p class="grey-text"><input type="text" name="seeking" id="seeking" placeholder="Seeking..." required></p>
                                </span>
                            </h3>

                            <!--Accordion wrapper-->
                            <div class="accordion md-accordion" id="accordionEx" role="tablist" aria-multiselectable="true">

                                <!-- Accordion card -->
                                <div class="card">

                                    <!-- Card header -->
                                    <div class="card-header" role="tab" id="headingOne1">
                                        <a data-toggle="collapse" data-parent="#accordionEx" href="#description" aria-expanded="true" aria-controls="description">
                                            <h5 class="mb-0">
                                                Description
                                                <i class="fas fa-angle-down rotate-icon"></i>
                                            </h5>
                                        </a>
                                    </div>

                                    <!-- Card body -->
                                    <div id="description" class="collapse show" role="tabpanel" aria-labelledby="description" data-parent="#accordionEx">
                                        <div class="card-body">
                                            <textarea type="text" name="description" id="description" form="newlisting" placeholder="Item Description. HTML not accepted" cols="45" required></textarea>
                                        </div>
                                    </div>
                                </div>
                                <!-- Accordion card -->

                                <!-- Accordion card -->
                                <div class="card">
                                    <!-- Card header -->
                                    <div class="card-header" role="tab" id="headingOne1">
                                        <a data-toggle="collapse" data-parent="#accordionEx" href="#condition" aria-expanded="true" aria-controls="condition">
                                            <h5 class="mb-0">
                                                Condition
                                                <i class="fas fa-angle-down rotate-icon"></i>
                                            </h5>
                                        </a>
                                    </div>

                                    <!-- Card body -->
                                    <div id="condition" class="collapse show" role="tabpanel" aria-labelledby="condition" data-parent="#accordionEx">
                                        <div class="card-body">
                                            <select id="condition" name="condition">
                                                <option value="brand_new">Brand New</option>
                                                <option value="used">Used</option>
                                                <option value="damaged">Damaged</option>
                                                <option value="toasted">Toasted</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- Accordion card -->

                                <!-- Accordion card -->
                                <div class="card">
                                    <!-- Card header -->
                                    <div class="card-header" role="tab" id="headingOne1">
                                        <a data-toggle="collapse" data-parent="#accordionEx" href="#seller" aria-expanded="true" aria-controls="seller">
                                            <h5 class="mb-0">
                                                About the Seller
                                                <i class="fas fa-angle-down rotate-icon"></i>
                                            </h5>
                                        </a>
                                    </div>

                                    <!-- Card body -->
                                    <div id="seller" class="collapse show" role="tabpanel" aria-labelledby="seller" data-parent="#seller">
                                        <div class="card-body">
                                            <span class="grey-text">Name: </span>
                                            <p><?= $_SESSION["userData"]->USER_NAME ?></p>
                                            <span class="grey-text">Location: </span>
                                            <p><?= $_SESSION["userData"]->USER_LOCATION ?></p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Accordion card -->

                            </div>
                            <!--/.Accordion wrapper-->

                            <!-- Make an Offer -->
                            <section class="color">
                                <div class="mt-5">

                                    <div class="row mt-3">
                                        <div class="col-md-12 text-center text-md-left text-md-right">
                                            <input type="submit" class="btn btn-primary btn-rounded fa-plus mr-2" value="Create a Listing">
                                            <p class="grey-text">By clicking "Create a Listing" you agree to our <a href="/tos.php">Terms of Service</a></p>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <!-- /.Add to Cart -->

                        </div>

                    </div>

                </section>
                <!--Section: Content-->


            </div>
        </form>
    </div>

</body>