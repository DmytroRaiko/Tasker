<?php 
require './auth_function.php';

if(isset($_POST['form-data'])){
    session_start();
    $formData = array();
    parse_str($_POST['form-data'], $formData);

    $error_array = check_auth_form_valid($formData);
    if(!empty($error_array)){
        echo json_encode($error_array);
    }
    else{
        
        $result_array = check_auth_values($formData);
        if(!array_key_exists('hash',$result_array)){
            echo json_encode($result_array);
        }
        else{
            if(isset($formData['remember-check'])){
                $cookie_hash = set_cookie_hash($result_array['user-id'], $result_array['user-login']);
                setcookie("remember_token", $cookie_hash, time() + (1000 * 60 * 60 * 24 * 30), '/');
            }
            else{
                if(isset($_COOKIE['remember_token'])){
                    setcookie("remember_token", '', time() - 3600, '/');
                }
            }
            $_SESSION['user_hash'] = $result_array['hash'];
            $_SESSION['user_id'] = $result_array['user-id'];
            echo "OK";
        }
    }
}