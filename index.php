<?php 
require_once "./db/database.php";
include_once("function.php");
?>
<!DOCTYPE html>
<html lang="en">
<?php
    head();
?>
<body>
    <?php
        site_header();
        //include "templates/modal-create-task.php";
    ?>
    <?php
        site_body();
    ?>
    

    <?php
        site_footer();
    ?>
    <div id="modal-output"></div>
</body>

</html>