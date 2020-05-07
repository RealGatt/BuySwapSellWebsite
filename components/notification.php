<?php

include_once("api/userapi.php");

if (isset($_SESSION["notification"])) {
?>
    <div class="alert alert-danger" role="alert">
        <?= $_SESSION["notification"] ?>
    </div>
<?php
    $_SESSION["notification"] = null;
}

?>