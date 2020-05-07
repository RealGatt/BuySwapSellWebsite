<?php

include_once("./api/itemapi.php");
include_once("./api/userapi.php");

if (!isset($initialItems) || is_null($initialItems)) {
    $initialItems = getItemsWithState("ACCEPTING_OFFERS"); // everything from db that is active.

    $initialItems = array_merge(getItemsWithState("SOLD"), $initialItems);
}

?>

<br>

<p>There are <?=sizeof(getAllItems())?> items listed in total, with <?=sizeof(getItemsWithState("SOLD"))?> of those having been Sold.</p>

<table id="itemTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th class="th-sm">Name
            </th>
            <th class="th-sm">Description
            </th>
            <th class="th-sm">Seeking
            </th>
            <th class="th-sm">Condition
            </th>
            <th class="th-sm">Status
            </th>
            <th class="th-sm">Relevant Course
            </th>
            <th class="th-sm">Seller
            </th>
            <th class="th-sm">Location
            </th>
            <th class="th-sm">Offers Made
            </th>
            <th class="th-sm">View
            </th>
        </tr>
    </thead>
    <tbody>

        <?php
        foreach ($initialItems as $item) {
            $user = getUserForID($item->SELLER_ID);?>
            <tr>
                <td><?= $item->ITEM_NAME ?></td>
                <td><?= $item->ITEM_DESC ?></td>
                <td><?= $item->SEEKING ?></td>
                <td><?= $item->ITEM_CONDITION ?></td>
                <td><?= getStatusFromString($item->ITEM_STATUS) ?></td>
                <td><?= strtoupper( $item->RELEVANT_COURSE_CODE) ?></td>
                <td><?= $user->USER_NAME ?></td>
                <td><?= $user->USER_LOCATION ?></td>
                <td><?= sizeof(getOffersForItem($item->ITEM_ID)) ?></td>
                <td><a href="/item.php?id=<?= $item->ITEM_ID ?>" class="btn btn-primary">View</a></td>
            </tr>
        <?php
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <th class="th-sm">Name
            </th>
            <th class="th-sm">Description
            </th>
            <th class="th-sm">Seeking
            </th>
            <th class="th-sm">Condition
            </th>
            <th class="th-sm">Status
            </th>
            <th class="th-sm">Relevant Course
            </th>
            <th class="th-sm">Seller
            </th>
            <th class="th-sm">Location
            </th>
            <th class="th-sm">Offers Made
            </th>
            <th class="th-sm">View
            </th>
        </tr>
    </tfoot>
</table>

<?php
$enableItemTable = false;

if ($enableItemTable){
    ?>
    <script>
        $(document).ready(function() {
            $('#itemTable').DataTable();
            $('.dataTables_length').addClass('bs-select');
        });
    </script>
    <?php
}
?>