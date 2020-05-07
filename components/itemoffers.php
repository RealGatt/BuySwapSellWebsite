<div class="col-lg-6 text-center text-md-left">
    <!-- Offers List -->
    <h2 class="h2-responsive text-center text-md-left product-name font-weight-bold dark-grey-text mb-1 ml-xl-0 ml-4">
        <strong>Previous Offers</strong>

        <?php
        $itemObj = getItemFromId($item);
        $offers = getOffersForItem($item);
        if (sizeof($offers) == 0) {
            echo "<p>No offers found. You can be the first!</p>";
        } else {
            if (isLoggedIn() && $itemObj->SELLER_ID == $_SESSION['userData']->USER_ID) {
                // show seller specific table
                ?>
                <table class="table">
                    <thead class="blue white-text">
                        <tr>
                            <th scope="col">Offer Time</th>
                            <th scope="col">Offerer</th>
                            <th scope="col">Offer</th>
                            <th scope="col">Accepted</th>
                            <th scope="col">Action</th>
                            <th scope="col">Message</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        foreach ($offers as $offr) {
                        ?>
                            <tr>
                                <th><?= $offr->TIME_SUBMITTED ?></th>
                                <td><?= getUserForId($offr->OFFERER_ID)->USER_NAME ?></td>
                                <td><?= clean($offr->OFFER) ?></td>
                                <td><?= $offr->ACCEPTED ? "Yes" : "No" ?></td>
                                <td><a href="/makeoffer.php?id=<?= $item ?>&action=accept&offerid=<?=$offr->OFFER_ID?>" class="btn btn-success btn-sm btn-rounded">
                                    <i class="fas fa-check mr-2" aria-hidden="true"></i> Accept</a></td>
                                <td><a href="/message.php?id=<?=$offr->OFFER_ID?>" class="btn btn-info btn-sm btn-rounded">
                                    <i class="fas fa-question mr-2" aria-hidden="true"></i> Message</a></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                <?php
            }else{
                // show regular table
                ?>
                <table class="table">
                    <thead class="blue white-text">
                        <tr>
                            <th scope="col">Offer Time</th>
                            <th scope="col">Offerer</th>
                            <th scope="col">Offer</th>
                            <th scope="col">Accepted</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        foreach ($offers as $offr) {
                        ?>
                            <tr>
                                <th><?= $offr->TIME_SUBMITTED ?></th>
                                <td><?= getUserForId($offr->OFFERER_ID)->USER_NAME ?></td>
                                <td><?= clean($offr->OFFER) ?></td>
                                <td><?= $offr->ACCEPTED ? "Yes" : "No" ?></td>
                            </tr>
                        <?php
                        }

                        ?>
                    </tbody>
                </table>
            <?php
            }
        }
        ?>

    </h2>
</div>