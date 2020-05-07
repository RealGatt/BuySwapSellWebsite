<?php

include_once("userapi.php");


class ItemStatus
{
    const SOLD = "Sold";
    const ACCEPTING_OFFERS = "Accepting Offers";
    const DELETED = "Deleted";
    const PAUSED = "Paused";
    const ON_HOLD = "On Hold";
}

function getOffersForItem($itemID)
{
    $offers = array();
    if (isset($itemID)) {

        $conn = new mysqli("localhost:3306", DB_USER, DB_PASSWORD, DB_DATABASE);

        // prepare a new statement - stops sql injection
        $stmt = $conn->prepare("SELECT * from offer WHERE book_id=?;");
        $stmt->bind_param("s", $itemID);

        $stmt->execute();

        $result = $stmt->get_result();

        mysqli_close($conn);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($row['book_id'] == $itemID) {

                    $itmofr = new ItemOffer(
                        $row["id"],
                        $row["user_id"],
                        $row["book_id"],
                        $row["offer"],
                        $row["accepted"],
                        $row["submitted"]
                    );


                    array_push($offers, $itmofr);
                }
            }
        }
    }

    return $offers;
}

function getStatusFromString($input)
{
    switch ($input) {
        case "SOLD":
            return ItemStatus::SOLD;
        case "ACCEPTING_OFFERS":
            return ItemStatus::ACCEPTING_OFFERS;
        case "DELETED":
            return ItemStatus::DELETED;
        case "PAUSED":
            return ItemStatus::PAUSED;
        case "ON_HOLD":
            return ItemStatus::ON_HOLD;
        default:
            return "UNKNOWN";
    }
}

function getOfferForUserAndId($USER_ID, $ITEM_ID){
    $conn = new mysqli("localhost:3306", DB_USER, DB_PASSWORD, DB_DATABASE);

    // prepare a new statement - stops sql injection
    $stmt = $conn->prepare("SELECT * from offer WHERE book_id=? AND user_id=?;");
    $stmt->bind_param("ss", $ITEM_ID, $USER_ID);

    $stmt->execute();

    $result = $stmt->get_result();

    mysqli_close($conn);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $itm = new ItemOffer(
                $row["id"],
                $row["user_id"],
                $row["book_id"],
                $row["offer"],
                $row["accepted"],
                $row["submitted"]
            );
            return $itm;
        }
    }
    return null;
}

function getOfferFromId(string $id)
{
    $conn = new mysqli("localhost:3306", DB_USER, DB_PASSWORD, DB_DATABASE);

    // prepare a new statement - stops sql injection
    $stmt = $conn->prepare("SELECT * from offer WHERE id=?;");
    $stmt->bind_param("s", $id);

    $stmt->execute();

    $result = $stmt->get_result();

    mysqli_close($conn);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($row['id'] == $id) {
                $itm = new ItemOffer(
                    $row["id"],
                    $row["user_id"],
                    $row["book_id"],
                    $row["offer"],
                    $row["accepted"],
                    $row["submitted"]
                );
                return $itm;
            }
        }
    }
    return null;
}

function getItemFromId(string $id)
{
    $conn = new mysqli("localhost:3306", DB_USER, DB_PASSWORD, DB_DATABASE);

    // prepare a new statement - stops sql injection
    $stmt = $conn->prepare("SELECT * from book WHERE id=?;");
    $stmt->bind_param("s", $id);

    $stmt->execute();

    $result = $stmt->get_result();

    mysqli_close($conn);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($row['id'] == $id) {
                $itm = new Item(
                    $row["user_id"],
                    $row["id"],
                    $row["title"],
                    $row["description"],
                    $row["seeking"],
                    $row["itemStatus"],
                    $row["itemCondition"],
                    $row["relevantCourse"],
                    explode(",", $row["pictures"])
                );
                return $itm;
            }
        }
    }
    return null;
}

function getAllItems(){
    $items = array();

    $conn = new mysqli("localhost:3306", DB_USER, DB_PASSWORD, DB_DATABASE);

    // prepare a new statement - stops sql injection
    $stmt = $conn->prepare("SELECT * from book;");
    $stmt->execute();

    $result = $stmt->get_result();

    mysqli_close($conn);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $itm = new Item(
                $row["user_id"],
                $row["id"],
                $row["title"],
                $row["description"],
                $row["seeking"],
                $row["itemStatus"],
                $row["itemCondition"],
                $row["relevantCourse"],
                explode(",", $row["pictures"])
            );


            array_push($items, $itm);
        }
        
    }
    

    return $items;
}

function getItemsWithState(string $state)
{

    $items = array();
    if (isset($state)) {

        $conn = new mysqli("localhost:3306", DB_USER, DB_PASSWORD, DB_DATABASE);

        // prepare a new statement - stops sql injection
        $stmt = $conn->prepare("SELECT * from book WHERE itemStatus=?;");
        $stmt->bind_param("s", $state);

        $stmt->execute();

        $result = $stmt->get_result();

        mysqli_close($conn);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($row['itemStatus'] == $state) {
                    $itm = new Item(
                        $row["user_id"],
                        $row["id"],
                        $row["title"],
                        $row["description"],
                        $row["seeking"],
                        $row["itemStatus"],
                        $row["itemCondition"],
                        $row["relevantCourse"],
                        explode(",", $row["pictures"])
                    );


                    array_push($items, $itm);
                }
            }
        }
    }

    return $items;
}


class ItemCondition
{
    const BRAND_NEW = "Brand New";
    const USED = "Used";
    const DAMAGED = "Damaged";
    const TOASTED = "Toasted, with a side of Bacon";
}

class ItemOffer
{

    public $OFFER_ID;
    public $OFFERER_ID; // the id of the user offering
    public $BOOK_ID;
    public $OFFER;
    public $ACCEPTED;
    public $TIME_SUBMITTED;

    function __construct($id, $oid, $bid, $offr, $acpt, $time)
    {
        $this->OFFER_ID = $id;
        $this->OFFERER_ID = $oid;
        $this->BOOK_ID = $bid;
        $this->OFFER = $offr;
        $this->ACCEPTED = $acpt;
        $this->TIME_SUBMITTED = $time;
    }

    function saveToDatabase()
    {

        $conn = new mysqli("localhost:3306", DB_USER, DB_PASSWORD, DB_DATABASE);
        if ($this->OFFER_ID < 0) { // new item
            try {
                $stmt = $conn->prepare("INSERT INTO offer (user_id, book_id, offer, accepted)
                VALUES (?,?,?,?);");

                $stmt->bind_param(
                    "ssss",
                    $this->OFFERER_ID,
                    $this->BOOK_ID,
                    $this->OFFER,
                    $this->ACCEPTED
                );

                $stmt->execute();

                $this->OFFER_ID = $conn->insert_id;
                return true;
            } catch (PDOException $e) {
                echo "<br>" . $e->getMessage();
                return false;
            }
        }else{
            try {
                $stmt = $conn->prepare("UPDATE offer SET user_id=?, book_id=?, offer=?, accepted=? WHERE id=?;");

                $stmt->bind_param(
                    "sssss",
                    $this->OFFERER_ID,
                    $this->BOOK_ID,
                    $this->OFFER,
                    $this->ACCEPTED,
                    $this->OFFER_ID
                );

                $stmt->execute();

                $this->OFFER_ID = $conn->insert_id;
                return true;
            } catch (PDOException $e) {
                echo "<br>" . $e->getMessage();
                return false;
            }
        }
    }
}

class Item
{

    public  $SELLER_ID;

    public  $ITEM_ID;

    public  $ITEM_NAME;
    public  $ITEM_DESC;
    public  $SEEKING;

    public  $ITEM_STATUS;
    public  $ITEM_CONDITION;

    public  $RELEVANT_COURSE_CODE;

    public  $ITEM_IMAGES;

    public  $OFFER_IDS;

    function saveToDatabase()
    {

        $conn = new mysqli("localhost:3306", DB_USER, DB_PASSWORD, DB_DATABASE);
        if ($this->ITEM_ID < 0) { // new item
            try {
                $stmt = $conn->prepare("INSERT INTO book (user_id, title, description, seeking, relevantCourse, itemCondition, itemStatus)
                VALUES (?,?,?,?,?,?,?);");

                $stmt->bind_param(
                    "sssssss",
                    $this->SELLER_ID,
                    $this->ITEM_NAME,
                    $this->ITEM_DESC,
                    $this->SEEKING,
                    $this->RELEVANT_COURSE_CODE,
                    $this->ITEM_CONDITION,
                    $this->ITEM_STATUS
                );

                $stmt->execute();

                $this->ITEM_ID = $conn->insert_id;
                return true;
            } catch (PDOException $e) {
                echo "<br>" . $e->getMessage();
            }
        }else{
            try {
                $stmt = $conn->prepare("UPDATE book SET itemStatus=? WHERE id=?;");

                $stmt->bind_param(
                    "ss",
                    $this->ITEM_STATUS,
                    $this->ITEM_ID
                );

                $stmt->execute();

                $this->OFFER_ID = $conn->insert_id;
                return true;
            } catch (PDOException $e) {
                echo "<br>" . $e->getMessage();
                return false;
            }
        }
    }

    function __construct(
        $sellerID,
        $id,
        $name,
        $desc,
        $seeking,
        string $status,
        string $condition,
        string $courseCodes,
        array $images
    ) {

        $this->SELLER_ID = $sellerID;
        $this->ITEM_ID = $id;

        $this->ITEM_NAME = strip_unsafe($name);
        $this->ITEM_DESC = strip_unsafe($desc);
        $this->SEEKING = strip_unsafe($seeking);

        $this->ITEM_STATUS = $status;
        $this->ITEM_CONDITION = $condition;

        $this->ITEM_IMAGES = $images;
        $this->RELEVANT_COURSE_CODE = strip_unsafe($courseCodes);
    }
}
