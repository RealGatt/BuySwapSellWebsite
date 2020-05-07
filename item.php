<?php
include_once("./api/itemapi.php");
include_once("./api/userapi.php");

if (!isset($_GET['id'])) {
    header("Location: /");
}

$item = $_GET["id"];

$itemInstance = getItemFromId($item);
if ($itemInstance == null) {
    $itemInstance = new Item(-1, $item, "Unknown Item", "Unknown Item", "Unknown Item", "Unknown Item", "Unknown Item", "Unknown Item", array());
}

$seller = getUserForID($itemInstance->SELLER_ID);

$title = $itemInstance->ITEM_NAME;

include_once("components/header.php");

?>

<body>
    <?php include_once("components/navbar.php"); ?>

    <?php include_once("components/notification.php"); ?>
    <div class="container" id="itemContainer">
        <div class="container my-5 py-5 z-depth-1">

            <section class="text-center">
                <h3 class="font-weight-bold mb-5">Item Details for <?= $itemInstance->ITEM_NAME ?> <span class="badge badge-warning"><?= getStatusFromString($itemInstance->ITEM_STATUS) ?></span></h3>

                <?php include("components/iteminfo.php"); ?>
                <br>

                <div class="row">
                    <?php include("components/itemoffers.php"); ?>
                    <div class="col-lg-5 text-center text-md-left">
                        <!-- Make an Offer -->
                        <section class="color">
                            <div class="mt-5">

                                <div class="row mt-3">
                                    <div class="col-md-12 text-center text-md-left text-md-right">
                                        <?php 

                                        if ($itemInstance->ITEM_STATUS == "ACCEPTING_OFFERS") { 
                                            $potentialOfferID = getOfferForUserAndId($_SESSION["userID"], $item);
                                            if ($potentialOfferID !== null){
                                                ?>
                                                <a href="/message.php?id=<?= $potentialOfferID->OFFER_ID ?>" class="btn btn-success btn-rounded">
                                                <i class="fas fa-feather mr-2" aria-hidden="true"></i> Messages</a>
                                                <?php
                                            }else{
                                                ?>
                                                <a href="/makeoffer.php?id=<?= $item ?>" class="btn btn-primary btn-rounded">
                                                <i class="fas fa-cart-plus mr-2" aria-hidden="true"></i> Make an Offer</a>
                                                <?php
                                            }
                                        } ?>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>

            </section>
        </div>
    </div>
</body>