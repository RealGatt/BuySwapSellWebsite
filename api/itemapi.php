<?php

include_once("userapi.php");


class ItemStatus{
    const SOLD = "Sold";
    const ACCEPTING_OFFERS = "Accepting Offers";
    const DELETED = "Deleted";
    const PAUSED = "Paused";
    const ON_HOLD = "On Hold";

    

}

function getStatusFromString($input){
    switch ($input){
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

function getItemsWithState(string $state){
    
    $items = array();
    if (isset($state)){

        $conn = new mysqli("localhost:3306", DB_USER, DB_PASSWORD, DB_DATABASE);
        
        // prepare a new statement - stops sql injection
        $stmt = $conn->prepare("SELECT * from book WHERE itemStatus=?;");
        $stmt->bind_param("s", $state);
        
        $stmt->execute();

        $result = $stmt->get_result();
        
        mysqli_close($conn);
        
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				if ($row['itemStatus'] == $state){
                    $itm = new Item($row["user_id"], $row["id"], $row["title"], 
                    $row["description"], $row["seeking"], $row["itemStatus"], $row["itemCondition"], 
                    explode(",", $row["relevantCourse"]), explode(",", $row["pictures"]));
                    

                    array_push($items, $itm);
				}
			}
        }
    }
    
	return $items;

}


class ItemCondition{
    const BRAND_NEW = "Brand New";
    const USED = "Used";
    const DAMAGED = "Damaged";
    const TOASTED = "Toasted, with a side of Bacon";
}

class Item{
    
    public  $SELLER_ID;

    public  $ITEM_ID;

    public  $ITEM_NAME;
    public  $ITEM_DESC;
    public  $SEEKING;

    public  $ITEM_STATUS;
    public  $ITEM_CONDITION;
    
    public  $RELEVANT_COURSE_CODES;

    public  $ITEM_IMAGES;

    public  $OFFER_IDS;

    function __construct($sellerID, $id, $name, $desc, $seeking, string $status, string $condition, array $courseCodes, array $images)
    {

        $this->SELLER_ID = $sellerID;
        $this->ITEM_ID = $id;

        $this->ITEM_NAME = $name;
        $this->ITEM_DESC = $desc;
        $this->SEEKING = $seeking;

        $this->ITEM_STATUS = $status;
        $this->ITEM_CONDITION = $condition;

        $this->ITEM_IMAGES = $images;
        $this->RELEVANT_COURSE_CODES = $courseCodes;

    }

}

?>