
<div class="row">

    <div class="col-lg-6">

        img goes here<br>

        // can i really be bothered adding images? not really...

    </div>

    <div class="col-lg-5 text-center text-md-left">

        <h2 class="h2-responsive text-center text-md-left product-name font-weight-bold dark-grey-text mb-1 ml-xl-0 ml-4">
            <strong><?= $itemInstance->ITEM_NAME ?></strong>
        </h2>
        <span class="badge badge-info product mb-4 ml-xl-0 ml-4">Courses: <?= $itemInstance->RELEVANT_COURSE_CODE ?></span>
        <h3 class="h3-responsive text-center text-md-left mb-5 ml-xl-0 ml-4">
            <span class="font-weight-bold">
                <strong>Seeking: </strong>
                <p class="grey-text"><?= $itemInstance->SEEKING ?></p>
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
                        <?= $itemInstance->ITEM_DESC ?>
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
                <div id="condition" class="collapse" role="tabpanel" aria-labelledby="condition" data-parent="#accordionEx">
                    <div class="card-body">
                        <?= $itemInstance->ITEM_CONDITION ?>
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
                <div id="seller" class="collapse" role="tabpanel" aria-labelledby="seller" data-parent="#seller">
                    <div class="card-body">
                        <span class="grey-text">Name: </span>
                        <p><?= $seller->USER_NAME ?></p>
                        <span class="grey-text">Location: </span>
                        <p><?= $seller->USER_LOCATION ?></p>
                    </div>
                </div>
            </div>
            <!-- Accordion card -->

        </div>
        <!--/.Accordion wrapper-->



    </div>
</div>