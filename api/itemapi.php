<?php

class ItemStatus{
    const SOLD = "Sold";
    const ACCEPTING_OFFERS = "Accepting Offers";
    const DELETED = "Deleted";
    const PAUSED = "Paused";
    const ONHOLD = "On Hold";
}


function getItemsWithState(string $state){
    // do MYSQL stuff

    $items = array();

    array_push($items, 
            new Item(1, 1, "A Cool Book", 
            "This book is required for Class XYZ",
            "60$ or a cup of really good coffee",
            ItemStatus::ACCEPTING_OFFERS, 
            ItemCondition::BRAND_NEW,
            array("itech3801"), array("8d8f8s.png")),

            new Item(1, 2, "Marshmallow", 
            "A yummy Marshwallow",
            "Ham Sandwich",
            ItemStatus::ACCEPTING_OFFERS, 
            ItemCondition::TOASTED,
            array("marsh1001"), array("mallow.png")),

            new Item(1, 3, "Useless Book", 
            "This book is required for Class ZYX, but you'll never use it. Like usual.",
            "Please just take it off my hands.",
            ItemStatus::ACCEPTING_OFFERS, 
            ItemCondition::USED,
            array("itech3801"), array("99222.png")),

            new Item(1, 4, "Lenovo Laptop", 
            "It's a laptop",
            "Thanos' Head",
            ItemStatus::ACCEPTING_OFFERS, 
            ItemCondition::USED,
            array("itech3801"), array("515.png")));

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