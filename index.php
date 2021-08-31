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
    $body = NULL;

    if (isset($_GET['project-id'])) {
        $body = 'task';
    } else if (isset($_GET['office-id'])) {
        $body = 'office';  
    }
   
    site_body($body);

    ?>
    

    <?php
        site_footer();
    ?>
    <div id="modal-output"></div>

    <div id="message-block"></div>
</body>

</html>