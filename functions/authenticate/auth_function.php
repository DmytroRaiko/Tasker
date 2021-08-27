<?php
require '../../db/database.php';

function check_reg_form_valid($form){
    $error = array();
    $emailPattern = '/^((?!\.)[\w\-_.]*[^.])(@\w+)(\.\w+(\.\w+)?[^.\W])$/';
    $passPattern = '/\w{6,40}/';
    if(!preg_match($emailPattern, $form['signup-email'])){
        $error['email_error'] = 'Email не відповідає шаблону';
    }
    if(!preg_match($passPattern, $form['signup-password'])){
        $error['pass_error'] = 'Пароль має бути не менше 6 символів і не містити спецсимволів';
    }
    if( $form['signup-password'] != $form['signup-repeat-password']){
        $error['rep_pass_error'] = 'Паролі не співпадають';
    }
    return $error;
    
}


function check_auth_values($values){
    $result = array();
    $db = new Database();
    $sql = $db -> query(
            "SELECT UserID, Password, Hash1, Login from user where Email = :login or Login = :login",
            [
                ":login" => $values['signin-login']
            ]
        );
    if(count($sql) == 0){
        $result['login_error'] = 'Такого логіна не знайдено';
    }
    else{

        if(!password_verify($values['signin-password'], $sql[0]['Password'])){
            $result['password_error'] = 'Пароль вказано невірно';
        }
        else{
            $result['hash'] = $sql[0]['Hash1'];
            $result['user-id'] = $sql[0]['UserID'];
            $result['user-login'] = $sql[0]['Login'];
        }
    }
    return $result;
}
function set_cookie_hash($id, $login){
    $db = new Database();
    $hash = crypt($login.date(DATE_ATOM), '$5$');
    $sql = $db -> query(
        "UPDATE user SET hash2 = :hash where UserID = :id",
        [
            ":hash" => $hash,
            ":id" => $id
        ]
    );
    return $hash;
}
?>