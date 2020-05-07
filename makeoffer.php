<?php
include_once("./api/itemapi.php");
include_once("./api/userapi.php");

if (!isLoggedIn()) {
    header("Location: /");
    die();
}


if (isset($_POST["submit"])){
    $slr = $_SESSION['userData'];
    $itemID = $_POST["itemid"];

    $newOffer = new ItemOffer(-1, $slr->USER_ID, $itemID, strip_unsafe($_POST['offer']), 0, time());

    if ($newOffer->saveToDatabase()){
        $_SESSION["notification"] = "Offer successfully submitted";
        header("Location: /item.php?id=".$itemID."&offerid=".$newOffer->OFFER_ID);
    }else{
        $_SESSION["notification"] = "Something went wrong when submitting your offer. Try again.";
        echo "Error while submitting your offer. Try again?";
    }
    return;
}

if (isset($_POST["accept"])){
    $offerID = $_POST["offerid"];
    $offerObj = getOfferFromId($offerID);
    $slr = $_SESSION['userData'];

    $itemInstance = getItemFromId($offerObj->BOOK_ID);

    if ($slr->USER_ID === $itemInstance->SELLER_ID){
        $offerObj->ACCEPTED = 1;
        $itemInstance->ITEM_STATUS = getStatusFromString("SOLD");
        $offerObj->saveToDatabase();
        $itemInstance->saveToDatabase();
        $_SESSION["notification"] = "Offer has been accepted!";
        header("Location: /item.php?id=".$offerObj->BOOK_ID."&offerid=".$offerObj->OFFER_ID);
        return;
    }
    
}

if (!isset($_GET['id'])) {
    header("Location: /");
}

$item = $_GET["id"];

$itemInstance = getItemFromId($item);
if ($itemInstance == null) {
    $_SESSION["notification"] = "Couldn't find the requested Item";
    header("Location: /");
}

$seller = getUserForID($itemInstance->SELLER_ID);

$title = "Making Offer - " . $itemInstance->ITEM_NAME;

$acceptingOffer = false;

if (isset($_GET["action"]) && $_GET["action"] == "accept"){
    $offerObj = getOfferFromId($_GET["offerid"]);
    $acceptingOffer = true;
}

include_once("components/header.php");

?>

<style>
    textarea {
        margin: 0;
        padding: 0;
        border-width: 0;
        width: inherit;
    }

    .textdiv {
        margin: 5px 0;
        padding: 3px;
        width: 100%;
        background: gray;
    }
</style>

<body>
    <?php include_once("components/navbar.php"); ?>

    <div class="container" id="itemContainer">
        <div class="container my-5 py-5 z-depth-1">

            <section class="text-center">

                <?php
            
                if (!$acceptingOffer){
                ?>
                    <h3 class="font-weight-bold mb-5">Submit Offer for <?= $itemInstance->ITEM_NAME ?> <span class="badge badge-warning"><?= getStatusFromString($itemInstance->ITEM_STATUS) ?></span></h3>

                    <form action="/makeoffer.php" name="offerForm" id="offerForm" method="post">
                        <input type="hidden" name="itemid" id="itemid" value="<?=$item?>">
                        <input type="hidden" id="submit" name="submit" value="true">
                        <?php
                        if ($itemInstance->ITEM_STATUS == "ACCEPTING_OFFERS") {
                        ?>
                            <div>
                                <div class="textdiv">
                                    <textarea name="offer" id="offer" form="offerForm" cols="" rows="" id="offer" placeholder="Your Offer Here" <?= $itemInstance->ITEM_STATUS != "ACCEPTING_OFFERS" ? "disabled" : "" ?>></textarea>
                                </div>
                            </div>
                        <?php
                        }

                        include("components/iteminfo.php");

                        ?>

                        <br>

                        <div class="row">

                            <?php include("components/itemoffers.php"); ?>

                            <div class="col-lg-5 text-center text-md-left">
                                <!-- Make an Offer -->
                                <section class="color">
                                    <div class="mt-5">

                                        <div class="row mt-3">
                                            <div class="col-md-12 text-center text-md-left text-md-right">
                                                <?php if ($itemInstance->ITEM_STATUS == "ACCEPTING_OFFERS") { // only show submit button if its accepting offers?>
                                                    <input type="submit" value="Submit Offer" form="offerForm" class="btn btn-primary btn-rounded" />
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </form>
                <?php   
                }else{
                ?>
                <h3 class="font-weight-bold mb-5">Accept Offer for <?= $itemInstance->ITEM_NAME ?> <span class="badge badge-warning"><?= getStatusFromString($itemInstance->ITEM_STATUS) ?></span></h3>
                <form action="/makeoffer.php" name="acceptOffer" id="acceptOffer" method="post">
                    <input type="hidden" name="itemid" id="itemid" value="<?=$item?>">
                    <input type="hidden" name="offerid" id="offerid" value="<?=$offerObj->OFFER_ID?>">
                    <input type="hidden" id="accept" name="accept" value="true">
                    <?php
                    if ($itemInstance->ITEM_STATUS == "ACCEPTING_OFFERS") {
                    ?>
                        <div>
                            <h4>Offer from <?=getUserForID($offerObj->OFFERER_ID)->USER_NAME?></h4>
                            <div class="textdiv">
                                <textarea disabled name="offer" id="offer" form="offerForm" cols="" rows="" id="offer" placeholder="Your Offer Here"><?=$offerObj->OFFER?></textarea>
                            </div>
                        </div>
                    <?php
                    }
                    include("components/iteminfo.php");
                    ?>
                    <br>
                    <div class="row">
                        <?php include("components/itemoffers.php"); ?>
                        <div class="col-lg-5 text-center text-md-left">
                            <!-- Make an Offer -->
                            <section class="color">
                                <div class="mt-5">

                                    <div class="row mt-3">
                                        <div class="col-md-12 text-center text-md-left text-md-right">
                                            <?php if ($itemInstance->ITEM_STATUS == "ACCEPTING_OFFERS") { // only show submit button if its accepting offers?>
                                                <p>By clicking "Accept Offer" below, you are accepting the currently displayed offer from <?=getUserForID($offerObj->OFFERER_ID)->USER_NAME?>.</p>
                                                <p>The items' status will automatically be changed to "SOLD" after clicking.</p>
                                                <input type="submit" value="Accept Offer" form="acceptOffer" class="btn btn-success btn-rounded" />

                                                <a href="/item.php?id=<?= $item ?>" class="btn btn-danger btn-rounded">
                                                     <i class="fas fa-ban mr-2" aria-hidden="true"></i> Cancel</a>

                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </form>
                <?php
                }
                ?>
            </section>

        </div>
    </div>

</body>