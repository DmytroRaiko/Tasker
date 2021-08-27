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
        include "templates/modal-create-task.php";
    ?>
    <?php
        site_body();
    ?>
    

    <?php
        site_footer();
    ?>
</body>

</html>