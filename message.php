<?php
include_once("./api/itemapi.php");
include_once("./api/userapi.php");
include_once("./api/messageapi.php");

if (!isLoggedIn()) {
    header("Location: /");
    die();
}

if (!isset($_GET['id']) && !isset($_POST["sendMessageID"])) {
    header("Location: /");
}

if (isset($_POST["sendMessageID"])){
    $target = $_POST["sendMessageID"];
    $msg = $_POST["message"];
    $slr = $_SESSION['userData'];
    sendMessage($slr, $target, $msg);
}else{
    $target = $_GET["id"];
}


$offerInstance = getOfferFromId($target);

$itemInstance = getItemFromId($offerInstance->BOOK_ID);
if ($itemInstance == null) {
    $itemInstance = new Item(-1, $item, "Unknown Item", "Unknown Item", "Unknown Item", "Unknown Item", "Unknown Item", "Unknown Item", array());
}

$seller = getUserForID($itemInstance->SELLER_ID);

$title = $itemInstance->ITEM_NAME;

include_once("components/header.php");

?>

<body>
    <?php include_once("components/navbar.php"); ?>

    <div class="container" id="itemContainer">
        <div class="container my-5 py-5 z-depth-1">

            <section class="text-center">
                <h3 class="font-weight-bold mb-5">Messages for <?= $itemInstance->ITEM_NAME ?> <span class="badge badge-warning"><?= getStatusFromString($itemInstance->ITEM_STATUS) ?></span></h3>
                <div id="messages">

                    <div class="card grey lighten-3 chat-room">
                        <div class="card-body">
                            <!-- Grid row -->

                            <div class="chat-message">

                                <ul class="list-unstyled chat-1 scrollbar-light-blue">
                                    <?php
                                    $messages = getMessagesForConversation($target);

                                    foreach ($messages as $message){
                                        ?>

                                        <li class="d-flex justify-content-between mb-4">
                                            <div class="chat-body white p-3 ml-2 z-depth-1" style="width:100%;">
                                                <div class="header" style="text-align: left;">
                                                    <strong class="primary-font"><?=$message->SENDER->USER_NAME?></strong>
                                                    <small class="pull-right text-muted"><i class="far fa-clock"></i> <?=$message->TIME_SENT?></small>
                                                </div>
                                                <hr class="w-100">
                                                <p class="mb-0" style="text-align: left;">
                                                    <?=clean($message->MESSAGE)?>
                                                </p>
                                            </div>
                                        </li>
                                        
                                        <?php
                                    }
                                    ?>
                                    
                                </ul>
                                <form action="message.php" method="post" name="sendMessage" id="sendMessage">
                                    <input type="hidden" name="sendMessageID" id="sendMessageID" value="<?=$target?>">
                                    <div class="white">
                                        <div class="form-group basic-textarea">
                                            <textarea form="sendMessage" name="message" id="message" class="form-control pl-2 my-0" id="exampleFormControlTextarea2" rows="3" placeholder="Type your message here..."></textarea>
                                        </div>
                                    </div>
                                    <input type="submit" value="Send" class="btn btn-outline-pink btn-rounded btn-sm waves-effect waves-dark float-right" />
                                    
                                </form>
                            </div>

                            <!-- Grid row -->
                        </div>
                    </div>
                </div>
                <br>
                <?php include("components/iteminfo.php"); ?>
            </section>
        </div>
    </div>
</body>