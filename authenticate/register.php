<?php 
require '../db/database.php';
require './auth_function.php';

if(isset($_POST['form-data'])){
    $formData = array();
    parse_str($_POST['form-data'], $formData);

    $error_array = check_reg_form_valid($formData);
    if(!empty($error_array)){
        echo json_encode($error_array);
    }
    else{
        /*$db = new Database();
        $sql = $db -> query(
            "SELECT count(*) from users"
        )*/
        //echo "OK";
    }
    
}

?>