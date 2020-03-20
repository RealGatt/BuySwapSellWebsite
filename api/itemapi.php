<?php

class ItemStatus{
    const SOLD = "Sold";
    const ACCEPTING_OFFERS = "Accepting Offers";
    const DELETED = "Deleted";
    const PAUSED = "Paused";
    const ONHOLD = "On Hold";
}


function getItemsWithState(ItemStatus $state){
    // do MYSQL stuff

    $items = array();

    array_push($items, new Item(1, "A Cool Book", 
            "This book is required for Class XYZ",
            "60$ or a cup of really good coffee",
            ItemStatus::ACCEPTING_OFFERS, 
            ItemCondition::TOASTED,
            array("itech3801"), array("8d8f8s.png")));

    return $items;

}


class ItemCondition{
    const BRAND_NEW = "Brand New";
    const USED = "Used";
    const DAMAGED = "Damaged";
    const TOASTED = "Toasted, with a side of Bacon";
}

class Item{
    function __construct($id, $name, $desc, $seeking, string $status, string $condition, array $courseCodes, array $images)
    {
        $ITEM_ID = $id;

        $ITEM_NAME = $name;
        $ITEM_DESC = $desc;
        $SEEKING = $seeking;

        $ITEM_STATUS = $status;
        $ITEM_CONDITION = $condition;

        $ITEM_IMAGES = $images;
        $RELEVANT_COURSE_CODES = $courseCodes;

    }

    private $ITEM_ID = 0;

    private $ITEM_NAME = "";
    private $ITEM_DESC = "";
    private $SEEKING = "";

    private $ITEM_STATUS = ItemStatus::DELETED;
    private $ITEM_CONDITION = ItemCondition::TOASTED;
    
    private $RELEVANT_COURSE_CODES = array();

    private $ITEM_IMAGES = array();

    private $OFFER_IDS = array();


}

?>