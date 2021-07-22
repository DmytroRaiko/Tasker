<?php include_once("function.php") ?>

<!DOCTYPE html>
<html lang="en">
<?php
    head();

    if(!empty($_GET["action"])){
        $action = $_GET["action"];
    }
    else {
        $action = 'signup';
    }
?>
<body>
    <?php
        site_header();
        
        sign_form();
    ?>
</body>

</html>