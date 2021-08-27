<?php 
include_once("function.php");
require_once './functions/authenticate/check_auth.php';
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
    
    if (isset($_GET['project-id']) ) {
        $body = 'task';
    } 
    site_body($body);

    ?>
    

    <?php
        site_footer();
    ?>
    <div id="modal-output"></div>
</body>

</html>