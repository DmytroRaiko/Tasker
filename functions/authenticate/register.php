<?php 

require './auth_function.php';

if(isset($_POST['form-data'])){
    $formData = array();
    parse_str($_POST['form-data'], $formData);

    $error_array = check_reg_form_valid($formData);
    if(!empty($error_array)){
        echo json_encode($error_array);
    }
    else{
        $db = new Database();
        $sql = $db -> query(
            "SELECT count(*) as cnt from user where email = :email",
            [
                ":email" => $formData['signup-email']
            ]
        );
        if($sql[0]['cnt'] == 0){
            $add_query = $db -> query(
                "insert into user (`Login`, `Email`, `Password`, `hash1`) values (:login, :email, :password, :hash)",
                [
                    ":login" => $formData['signup-login'],
                    ":email" => $formData['signup-email'],
                    ":password" => password_hash($formData['signup-password'], PASSWORD_DEFAULT),
                    ":hash" => md5($formData['signup-email'])
                ]
            );
            if(empty($add_query)){
                echo "OK";
            }
            else{
                echo json_encode(["undef_error" => $add_query['error']]);
            }
        }
        else{
            echo json_encode(["create_error" => "Обліковий запис з такою електронною адресою вже існує"]);
        }

    }
    
}

?>